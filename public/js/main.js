$(document).ready(function(){
    console.log("We are ready to rock and roll!");

    $('#mainNav li a').each(function(){
        if($(this).prop("href") == window.location.href)
            $(this).parents('li').addClass('active');
        else
            $(this).parents('li').removeClass('active');
    });
});