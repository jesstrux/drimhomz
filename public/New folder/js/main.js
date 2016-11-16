const client_secret = "jeDMaCEbK8KlxyWPlHUq53jzzkz8TPLnCWSxBSP7";

$(document).ready(function(){
    console.log("We are ready to rock and roll!");


    const post_data = {
        grant_type: 'password',
        client_id: 2,
        client_secret: client_secret,
        username: 'wolpertjamie@gmail.com',
        password: 'password',
        scope: ''
    }

    $.post('oauth/token', post_data, function(data) {
        // console.log(data);
        // const token = data.access_token;
        const token = "";

        $.ajax({
            url: 'oauth/clients',
            type: 'GET',
            dataType: 'json',
            headers: {
                "Authorization": "Bearer: " + token
            }
        })
        .done(function(data) {
            console.log(data);
        })
        .fail(function(error) {
            console.log(error);
        })
        .always(function() {
            console.log("complete");
        });
        
    });


    $('.image-grid').masonry({
        columnWidth: '.grid-sizer',
        itemSelector: '.grid-item',
        percentPosition: true
    });
});