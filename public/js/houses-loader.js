var house_details, cur_house;
var featured_houses = [];

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

      html += '<li id="house'+house.id+'"  class="dh-card grid-item" data-postid="'+house.id+'">';
      html +=   '<div class="image">';
      html +=     '<img src="'+house.image_url+'" alt="'+house.title+'">';
      html +=   '</div>';
      html +=   '<div class="content">';
      html +=     '<h3>'+house.title+'</h3>';
      html +=     '<p>'+house.description+'</p>'
      html +=     '<span class="social-stuff">'+likes_text+' | '+comments_text+'</span>'
      html +=   '</div>';
      html +=  '</li>';
    }

    $newHouses = $(html);

    // Apply layout.
    applyLayout($newHouses);
  };

  // Capture scroll event.
  $document.on('scroll', onScroll);

  // Load first data from the API.
  loadData();

  $(document).on("click", '.--js-house-preview .closer', function(e){
    $preview = $(".--js-house-preview");

    if($preview.hasClass('open')){
      $preview.removeClass('open');
      $('body').removeClass('locked');
    }
  });
  $(document).on("click", '.dh-card.grid-item', function(e){
    cur_house = $(this).index();
    house_details = featured_houses[cur_house];
    var preview = document.querySelector(".--js-house-preview");
    var previewCard = document.querySelector(".--js-house-preview-card");
    var previewBox = previewCard.getBoundingClientRect();
    var el = e.currentTarget;
    var elBox = el.getBoundingClientRect();

    $('#previewTitle').text(house_details.title);
    $('#previewCaption').text(house_details.description);
    $('#previewCommentCount').text(house_details.comment_count);
    $('#previewFavCount').text(house_details.fav_count);
    $('#previewImage').attr("src", house_details.image_url);
    $('#previewUsername').text(house_details.owner.fname + " " + house_details.owner.lname);
    $('#previewUserdp').attr("src", "images/uploads/" + house_details.owner.dp || "images/dp.png");
    $('.previewHouseId').val(house_details.id);
    
    if(house_details.faved)
      $('#previewReactions').addClass("faved");
    else
      $('#previewReactions').removeClass("faved");

    $('#commentsList').find(".a-comment").remove();

    if(house_details.comment_count < 1){
      $('#commentsList').addClass('no-comments');
    }else{
      $('#commentsList').removeClass('no-comments');
      $('#previewComments').addClass('loading');
    }
      
    $('.--js-house-preview .dh-card').scrollTop(0);

    var translateX = (elBox.left + (elBox.width / 2)) - (previewBox.left + (previewBox.width / 2));
    var translateY = (elBox.top + (elBox.height / 2)) - (previewBox.top + (previewBox.height / 2));
    var translate = 'translate(' + translateX + 'px,' + translateY + 'px)';
    var size = Math.max(previewBox.width + Math.abs(translateX) * 2, previewBox.height + Math.abs(translateY) * 2);
    var diameter = Math.sqrt(2 * size * size);
    var scaleX = diameter / previewBox.width;
    var scaleY = diameter / previewBox.height;
    var scale = 'scale(' + scaleX + ',' + scaleY + ')';
    var transform = scale + " " + translate;
    previewCard.style.transformOrigin = previewCard.style.webkitTransformOrigin = "50% 50%";

    var animation = previewCard.animate([
        {opacity: 0, transform: translate + "scale(0)"},
        {opacity: 1.0, transform: "none"}
    ], {
        duration: 200
    });

    setTimeout(function(){
      previewCard.style.transform = previewCard.style.webkitTransform = "none";
      preview.classList.add("open");
      $('body').addClass('locked');

      setTimeout(function(){
        loadComments(house_details.id);
      },150);
    }, 100);
  });


  function loadComments(house) {
    $.ajax({
      url: "/comments/" + house,
      type: 'GET',
      dataType: 'json'
    })
    .done(function(data) {
      onLoadComments(data);
    })
    .fail(function(error) {
      console.log(error);
    })
    .always(function() {
      console.log("Comments loaded!");
    });
  };

  function onLoadComments(data) {
    var i = 0, length = data.length;
    $('#previewComments').removeClass('loading');

    for (; i < length; i++) {
      var comment = $(comment_template(data[i]));
      comment.find("form").prepend(_token);
      $('#commentsList').append(comment);
    }
  };
})(jQuery);