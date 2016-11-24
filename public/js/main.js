$(document).ready(function(){
    console.log("We are ready to rock and roll!");

    $('#mainNav li a').each(function(){
        if($(this).prop("href") == window.location.href)
            $(this).parents('li').addClass('active');
        else
            $(this).parents('li').removeClass('active');
    });

  /**
   * When scrolled all the way to the bottom, add more tiles
   */
  function onScroll() {
    // Check if we're within 100 pixels of the bottom edge of the broser window.
    var winHeight = window.innerHeight ? window.innerHeight : $window.height(), // iphone fix
        closeToBottom = ($window.scrollTop() + winHeight > $document.height() - 100);

    if (closeToBottom) {
      // Get the first then items from the grid, clone them, and add them to the bottom of the grid
      var $items = $('li', $container),
          $firstTen = $items.slice(0, 10).clone().css('opacity', 0);
      $container.append($firstTen);

      wookmark.initItems();
      wookmark.layout(true, function () {
        // Fade in items after layout
        setTimeout(function() {
          $firstTen.css('opacity', 1);
        }, 300);
      });
    }
  };

  // Capture scroll event.
  // $window.bind('scroll.wookmark', onScroll);


    $(document).on("click", '#profilePage aside a', function(){
        var curIdx = $('#profilePage aside li.active').index();
        var nextIdx = $(this).parents("li").index();
        var animDir = curIdx > nextIdx ? "down" : "up";
        var target = $(this).data('target');

        $('#profilePage aside li.active').removeClass('active');
        $(this).parents("li").addClass('active');
        $('#profilePage .subpage.current').removeClass('current');
        $(target).addClass('current');

        console.log(curIdx, nextIdx ,animDir);
    });
});