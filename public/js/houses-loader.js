var featured_houses = [];
first_load = true;

(function ($) {
  var wookmark = undefined,
      page = 1,
      isLoading = false,
      apiURL = 'randomHouses',
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

    imagesLoaded(container, function () {
      // Destroy the old handler
      if (wookmark === undefined) {
        wookmark = new Wookmark(container, {
          offset: 10
        });
      } else {
        wookmark.initItems();
        wookmark.layout(true);
      }

      // Set opacity for each new image at a random time
      $newImages.each(function () {
        var $self = $(this);
        window.setTimeout(function () {
          $self.css('opacity', 1);
        }, Math.random() * fadeInDelay);
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
    
    isLoading = true;
    $loaderMessage.addClass("open");
    // console.log("Loading data!", window.Laravel.csrfToken);

    $.ajax({
      url: apiURL + "/" + page,
      type: 'GET',
      dataType: 'json'
    })
    .done(function(data) {
      onLoadData(data);
    })
    .fail(function(error) {
      if(error.responseText == "No more"){
        $document.off('scroll', onScroll);
        $noMoreMessage.addClass("open");
      }else{
        console.log(error);
      }
    })
    .always(function() {
      isLoading = false;
      $loaderMessage.removeClass("open");
      console.log("Data loaded!");
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
        var ad_idx = i == 0 ? i : 2;
        html += getAd(ad_idx);
      }

      html += '<li style="cursor: pointer;" id="house'+house.id+'"  class="dh-card grid-item a-house" data-postid="'+house.id+'">';
      html +=   '<div class="image">';
      html +=     '<img src="' + house_base_url + house.image_url+'" alt="'+house.title+'">';
      html +=   '</div>';
      html +=   '<div class="content">';
      html +=     '<h3>'+house.title+'</h3>';
      html +=     '<a class="user-link" href="/user/'+house.owner.id+'" data-user-id="'+house.owner.id+'">'+house.owner.fname + ' ' + house.owner.lname + '</a>'
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
    return tangazo_tpl(random_ads[i]);
  }
  // Load first data from the API.
  loadData();

  // $(".user-link").css({opacity: 0});
})(jQuery);