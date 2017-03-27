var featured_houses = featured_houses ||  [];
first_load = true;

(function ($) {
  var wookmark = undefined,
      page = 1,
      isLoading = false,
      apiURL = '/randomHouses',
      lastRequestTimestamp = 0,
      fadeInDelay = 2000,
      container = '#container',
      $container = $(container),
      $loaderMessage = $('#loaderMessage'),
      $noMoreMessage = $('#noMoreMessage'),
      $window = $(window),
      $document = $(document);

  /**
   * When scrolled all the way to the bottom, add more tiles.
   */
  function onScroll(event) {
    // Only check when we're not still waiting for data.
    if (!isLoading) {
      // Check if we're within 100 pixels of the bottom edge of the broser window.
      var closeToBottom = ($window.scrollTop() + $window.height() > $document.height() - 100);
      if (closeToBottom) {
        // Only allow requests every second
        var currentTime = new Date().getTime();
        if (lastRequestTimestamp < currentTime - 1000) {
          lastRequestTimestamp = currentTime;
          loadData();
        }
      }
    }
  };

  /**
   * Refreshes the layout.
   */
  function applyLayout($newImages) {
    $container.append($newImages);
    showLoading();
    imagesLoaded(container, function () {
      hideLoading();
      // Destroy the old handler
      if (wookmark === undefined) {
        wookmark = new Wookmark(container, {
          offset: 10,
          align: 'left'
        });
      } else {
        wookmark.initItems();
        wookmark.layout(true);
      }

      window.setTimeout(function(){
        isLoading = false;
        $loaderMessage.removeClass("open");
      }, fadeInDelay + 300);

      // Set opacity for each new image at a random time
      $newImages.each(function () {
        var $self = $(this);
        window.setTimeout(function () {
          $self.css('opacity', 1);
        }, Math.random());
      });

      $(".user-link").each(function(){
        $(this).webuiPopover({
            type:'async',
            trigger:'hover',
            url:'/userProfilePopup/'+$(this).data('user-id')
        });
      })
    });
  };

  /**
   * Loads data from the API.
   */
  function loadData() {
    if(!$(container).length)
      return;
    
    //isLoading = true;
    //$loaderMessage.addClass("open");
    // console.log("Loading data!", window.Laravel.csrfToken);
    showLoading();
    $.ajax({
      url: apiURL + "/" + page,
      type: 'GET',
      dataType: 'json'
    })
    .done(function(data) {
      var houses = data.houses;
      if(houses && houses.length){
        onLoadData(houses);
      }

      //isLoading = false;
      //$loaderMessage.removeClass("open");

      if(!data.more){
        $document.off('scroll', onScroll);

        $noMoreMessage.addClass("open");
      }
    })
    .fail(function(error) {
      console.log(error);
    })
    .always(function() {
      console.log("Data loaded!");
      hideLoading();
    });
  };

  /**
   * Receives data from the API, creates HTML for images and updates the layout
   */
  function onLoadData(data) {
    if(data.length){
      page++; // Increment page index for future calls.
      featured_houses = featured_houses.concat(data);
      // console.log(featured_houses);
    }

    // Create HTML for the images.
    var html = '',
        // data = response.data,
        i = 0, length = data.length, house, opacity,
        $newHouses;

    for (; i < length; i++) {
      house = data[i];

      var ltrailingS = house.fav_count == 1 ? "" : "s";
      var likes_text = house.fav_count + " like" + ltrailingS;

      var ctrailingS = house.comment_count == 1 ? "" : "s";
      var comments_text = house.comment_count + " comment" + ctrailingS;

      if(first_load && (i == 0 || i == 3)){
        var ad_idx = i == 0 ? i : 1;
        html += getAd(ad_idx);
      }

      var actions_html = "";
      if(user_exists){
        var followed_str = "FOLLOW";
        var followed_class = "";

        if(house.followed){
          followed_str = "UNFOLLOW";
          followed_class = "followed";
        }

        var post_actions = '<div class="post-actions">';
        post_actions += '<button class="btn drim-btn"><img class="drimmer" src="images/drim.png" height="20px"/></button>';
        post_actions += '<form action="" id="followHouse'+house.id+'" method="POST"><input type="hidden" name="_token" value="'+Laravel.csrfToken+'"/><button class="btn follow-house-btn '+followed_class+'" type="button" onclick="followHouse('+house.id+')">'+followed_str+'</button></form>';
        post_actions += '</div>';

        actions_html = post_actions;
      }

      // console.log(cur_user.id.length);
      var ratio;
      var win_w = window.innerWidth;
      var el_w;

      if(win_w <= 768){
        el_w = win_w / 2;
      }
      else if(win_w > 768 && win_w <= 900){
        el_w = win_w / 3;
      }
      else{
        el_w = win_w / 5;
      }
      ratio = house.width_thumb / el_w;
      var shorter_height = house.height_thumb / ratio;

      console.log(house.width_thumb, house.height_thumb);
      console.log(ratio, el_w, shorter_height);

      var ratio_height = shorter_height + 'px';

      html += '<li style="cursor: pointer;" id="house'+house.id+'"  class="dh-card grid-item a-house" data-postid="'+house.id+'">';
      html +=   actions_html;
      html +=   '<div class="image" style="background-color: '+house.placeholder_color+';heigh:'+ratio_height+'">';
      html +=     '<img style="background-color: transparent;" src="' + house_base_url + 'thumbs/' + house.image_url+'" alt="'+house.title+'">';
      html +=   '</div>';
      html +=   '<div class="content">';
      html +=     '<h3>'+house.title+'</h3>';
      html +=     '<a class="user-link hidden-xs hidden-sm" href="/user/'+house.owner.id+'" data-user-id="'+house.owner.id+'">'+house.owner.fname + ' ' + house.owner.lname + '</a>'
      html +=     '<a class="hidden visible-xs visible-sm" onclick="showUserBottomSheet('+house.owner.id+')">'+house.owner.fname + ' ' + house.owner.lname + '</a>'
      html +=     '<span class="social-stuff">'+likes_text+' | '+comments_text+'</span>'
      html +=   '</div>';
      html +=  '</li>';
    }

    first_load = false;

    $newHouses = $(html);

    // Apply layout.
    applyLayout($newHouses);
  };

  // Capture scroll event.
  $document.on('scroll', onScroll);
  
  function getAd(i){
    if(random_ads && random_ads.length)
      return tangazo_tpl(random_ads[i]);
    else
      return "";
  }
  // Load first data from the API.
  loadData();

  // $(".user-link").css({opacity: 0});
})(jQuery);