var house_details, cur_house;
var hovering = false;
var cur_popup;
var cur_popup_area;
var loc = window.location.host + "/";

$(document).ready(function(){
    console.log("We are ready to rock and roll!");

    $('#mainNav li a').each(function(){
        if($(this).prop("href") == window.location.href)
            $(this).parents('li').addClass('active');
        else
            $(this).parents('li').removeClass('active');
    });

    $(document).on("click", '.house-card', function(e){
        if(!$(this).data("house"))
            return;

        house_details = $(this).data("house");
        house_details.owner = $(this).data("user");
        house_details.fav_count = $(this).data("favs");
        house_details.comment_count = $(this).data("comments");
        setPreview(e);
        // console.log(house_details);
    });

    $(document).on("click", '.dh-card.grid-item.a-house', function(e){
        if(e.target.localName == "a")
          return;

        if(cur_popup){
          cur_popup.remove();
          getPopup(e);
        }

        var index_moi = $(this).index();
        cur_house = index_moi;
        cur_house -= index_moi < 4 ? 1 : 2;
        console.log(index_moi);

        house_details = featured_houses[cur_house];
        setPreview(e);
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
          if(data[i].user_id == cur_user.id || house_details.owner.id == cur_user.id){
            comment.addClass('my-comment');
          }
          comment.find("form").prepend(_token);
          $('#commentsList').append(comment);
        }
    }

    function getPopup(e){
        var el = e.target;
        cur_popup_area = el;

        id = $(el).data("user-id");
        console.log("Foun it: " + id);
        if(!id)
          return;

        $.get("/userProfilePopup/"+id, function (response) {
            cur_popup = $(response);
            // console.log(el);
            cur_popup.css({left: e.clientX - 140, top: e.clientY - 200});
            $('body').append(cur_popup);
        });
    }

    $(document).on("click", '.--js-house-preview .closer', function(e){
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

    function setPreview(e){
        cur_house = $(this).index();
        var preview = document.querySelector(".--js-house-preview");
        var previewCard = document.querySelector(".--js-house-preview-card");
        var previewBox = previewCard.getBoundingClientRect();
        var el = e.currentTarget;
        var elBox = el.getBoundingClientRect();

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
    comment += '        <button type="button" onclick="deleteComment('+commentObj.id+')">'
    comment += '            delete';
    comment += '        </button>';
    comment += '    </form>';
    comment += '</div>';

    return comment;
}