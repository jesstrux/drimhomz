(function ($) {
  var wookmark = undefined,
      page = 1,
      isLoading = false,
      apiURL = '/randomHouses',
      lastRequestTimestamp = 0,
      fadeInDelay = 2000,
      container = '#container',
      $container = $(container),
      $loaderCircle = $('#loaderCircle'),
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
    isLoading = true;
    $loaderCircle.show();
    console.log("Loading data!", window.Laravel.csrfToken);

    $.ajax({
      url: apiURL + "/" + page,
      dataType: 'json', // Set to jsonp if you use a server on a different domain and change it's setting accordingly
      success: onLoadData,
      error: onLoadDataError
    });
  };

  function onLoadDataError(error){
    console.log(error);
  }

  /**
   * Receives data from the API, creates HTML for images and updates the layout
   */
  function onLoadData(data) {
    isLoading = false;
    $loaderCircle.hide();
    console.log("Data loaded!");

    // Increment page index for future calls.
    page++;

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

      html += '<li class="dh-card grid-item">';
      html +=   '<div class="image">';
      html +=     '<img src="'+house.image_url+'" alt="'+house.name+'">';
      html +=   '</div>';
      html +=   '<div class="content">';
      html +=     '<h3>'+house.title+'</h3>';
      html +=     '<p>'+house.description+'</p>'
      html +=     '<span class="social-stuff">'+likes_text+' | '+comments_text+'</span>'
      html +=   '</div>';
      html +=  '</li>';
    }

    $newHouses = $(html);

    // Disable requests if we reached the end
    if (data == null) {
      $document.off('scroll', onScroll);
    }

    // Apply layout.
    applyLayout($newHouses);
  };

  // Capture scroll event.
  $document.on('scroll', onScroll);

  // Load first data from the API.
  loadData();
})(jQuery);