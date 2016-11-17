const client_secret = "jeDMaCEbK8KlxyWPlHUq53jzzkz8TPLnCWSxBSP7";

$(document).ready(function(){
    console.log("We are ready to rock and roll!");

    $('#mainNav li a').each(function(){
        if($(this).prop("href") == window.location.href)
            $(this).parents('li').addClass('active');
        else
            $(this).parents('li').removeClass('active');
    });

    $('.image-grid').masonry({
        columnWidth: '.grid-sizer',
        itemSelector: '.grid-item',
        percentPosition: true
    });


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