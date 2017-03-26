var house_details = {}, cur_house;
var hovering = false;
var cur_popup;
var cur_popup_area;
var loc = window.location.host + "/";
var is_cur_house;

$(document).ready(function(){
    console.log("We are ready to rock and roll!");

    if ("onhashchange" in window) {
        // alert("The browser supports the hashchange event!");
        window.onhashchange = locationHashChanged;
    }

    function locationHashChanged() {
        var hash = location.hash;
        if (hash.indexOf("house") != -1) {
            var hash = window.location.hash;
            var house_id = hash.substr(6, hash.length);
            console.log("new house " + house_id);

            getHouse(house_id);
        }
    }

    locationHashChanged();

    $(document).on("keyup", "#searchBar input", function(e){
        console.log(e.keyCode);

        if(e.keyCode == 27 || e.keyCode == 13){
            closeSearchBar();
            return;
        }else{
            var val = $(this).val();
            if(val.length){
                search(val);
                $("#searchBar").addClass('search-started');
            }else{
                $("#searchBar").removeClass('search-started');
            }
        }
    });

    $('#mainNav li a').each(function(){
        if(window.location.href.indexOf($(this).prop("href")) != -1)
            $(this).parents('li').addClass('active');
        else
            $(this).parents('li').removeClass('active');
    });

    $(".user-link").each(function(){
        $(this).webuiPopover({
            type:'async',
            trigger:'hover',
            url:'/userProfilePopup/'+$(this).data('user-id')
        });
    });

    $(document).on("click", '.a-house-item', function(e){
        if(!$(this).data("house"))
            return;

        var house = $(this).data("house");
        is_cur_house = house_details.id == house.id;
        
        if(!is_cur_house){
            house_details = house;
            house_details.owner = $(this).data("user");
            house_details.fav_count = $(this).data("favs");
            house_details.comment_count = $(this).data("comments");
            setPreview();
        }
        showHouse(e);
        // console.log(house_details);
    });

    $(document).on("click", '.drim-btn', function(){
        $parent = $(this).closest('.dh-card');

        $('--js-house-preview-card').removeClass('open');

        // if(($parent).hasClass('--js-house-preview-card'))
            // return;

        openNewPin($parent);
    });

    $(document).on("click", '.dh-card.grid-item.a-house', function(e){
        var localName = e.target.localName;
        if(localName == "a" || localName == "button" || e.target.classList.contains("drimmer"))
          return;
        console.log(localName);

        if(cur_popup){
          cur_popup.remove();
          getPopup(e);
        }

        var index_moi = $(this).index();
        index_moi -= index_moi < 4 ? 1 : 2;
        is_cur_house = cur_house == index_moi;

        if(!is_cur_house){
            cur_house = index_moi;
            house_details = featured_houses[cur_house];
            setPreview(e);
        }

        showHouse(e);
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

        if(length < 1)
            $('#commentsList').addClass('no-comments');

        for (; i < length; i++) {
          var comment = $(comment_template(data[i]));
          if((user_exists && data[i].user_id == cur_user.id) || (user_exists && house_details.owner.id == cur_user.id)){
            comment.addClass('my-comment');
          }
          comment.find("form").prepend(_token);
          $('#commentsList').append(comment);
        }
    }

    $(document).on("click", '.--js-house-preview-closer', function(e){
        $preview = $(".--js-house-preview");

        if($preview.hasClass('open')){
          $preview.removeClass('open');
          $('body').removeClass('locked');
        }
    });

    $(document).on("mouseenter", ".user-linker", function(e){
        hovering = true;
        setTimeout(function(){
          if(hovering){
            if(cur_popup){
              cur_popup.remove();
              getPopup(e);
            }else{
              getPopup(e);
            }
            hovering = false;
          }
        }, 1500);
    });

    $(document).on("mouseleave", ".user-linker", function(e){
        setTimeout(function(){
          if(cur_popup){
            cur_popup.remove();
            hovering = false;
          }
        }, 1500)
    });

    function setPreview(){
        $('#preview .dh-card').attr('data-postid', house_details.id);
        $('#previewTitle').text(house_details.title);
        $('#previewCaption').text(house_details.description);
        $('#previewCommentCount').text(house_details.comment_count);
        $('#previewFavCount').text(house_details.fav_count);
        $('#previewImageHolder').css('background-color', house_details.placeholder_color);
        $('#previewImage').attr("src", house_base_url + house_details.image_url);
        $('#previewUsername').text(house_details.owner.fname + " " + house_details.owner.lname);
        $('#previewUsername').prop("href", "/user/" + house_details.owner.id);
        $('#previewUserdp').attr("src",  user_base_url + house_details.owner.dp || "images/dp.png");
        $('.previewHouseId').val(house_details.id);

        if(house_details.faved)
          $('#previewReactions').addClass("faved");
        else
          $('#previewReactions').removeClass("faved");

        $('#commentsList').find(".a-comment").remove();
        // $('.--js-house-preview .dh-card').scrollTop(0);
    }

    function showHouse(e){
        var preview = document.querySelector(".--js-house-preview");
        var previewCard = document.querySelector(".--js-house-preview-card");
        var previewBox = previewCard.getBoundingClientRect();
        var el = e.currentTarget;
        var elBox = el.getBoundingClientRect();
        
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

        if(!is_cur_house){
            
        }

        setTimeout(function(){
          previewCard.style.transform = previewCard.style.webkitTransform = "none";
          preview.classList.add("open");
          $('body').addClass('locked');

            if (!is_cur_house) {
                setTimeout(function(){
                    if(house_details.comment_count < 1){
                      $('#commentsList').addClass('no-comments');
                    }else{
                      $('#commentsList').removeClass('no-comments');
                      $('#previewComments').addClass('loading');
                      loadComments(house_details.id);
                    }
                },150);
            }
        }, 100);
    }
});


function comment_template(commentObj) {
    if(!commentObj.id)
        commentObj.id = "";

    comment = '';
    comment += '<div id="comment'+commentObj.id+'" class="a-comment item flex">';
    comment += '    <div class="avatar">';
    comment += '        <img src="'+ user_base_url + commentObj.user.dp+'" alt="'+commentObj.user.fname+'s dp">';
    comment += '    </div>';
    comment += '    <div class="item-text">';
    comment += '        <div class="title">';
    comment += '        <a href="/user/'+commentObj.user.id+'">'
    comment += '            '+commentObj.user.fname+ ' ' + commentObj.user.lname+'</a>';
    comment += '        </div>';
    comment += '        <p>'+commentObj.content+'</p>';
    comment += '    </div>';
    comment += '    <form id="deleteComment'+commentObj.id+'" action="deleteComment" method="POST">';
    comment += '        <input id="commentId" type="hidden" value="'+commentObj.id+'" name="id">';
    comment += '        <a type="button" style="cursor: pointer" onclick="deleteComment('+commentObj.id+')">'
    comment += '            <i class="fa fa-trash" title="Delete"></i>';
    comment += '        </a>';
    comment += '    </form>';
    comment += '</div>';

    return comment;
}

function openSearchBar(){
    $("body").addClass("open-search");
    $("#searchBar input").focus();
}

function closeSearchBar(){
    $("body").removeClass("open-search");
}

function emptySearchBar(){
    $("#searchBar input").val("").focus();
    $("#searchBar").removeClass('search-started');
}

function search(q){
    var form = $("#searchBar form");
    var url = form.attr('action') + '/' + q;
    $("#searchResults").addClass("searching");

    $.get(url, function(data){
        $("#searchResults").removeClass("searching");
        $("#searchResults #results").html(data);
    });
}


function getHouse(id){
    $.get("/getHouse/"+id, function(house){
        console.log(house);
    });
}
