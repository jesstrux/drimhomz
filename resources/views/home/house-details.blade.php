<div id="house_details" class="cust-modal open">
    <button class="closer --js-house-preview-closer">
        <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>
    
    @include('houses.details')
</div>

<script>
    var _prev_token = '<input type="hidden" name="_token" value="'+ '<?php echo csrf_token(); ?>' +'">';
    var cur_user = <?php echo Auth::guest() ?: Auth::user(); ?>;

    $("#submitComment textarea")
        .on("focus", function(){
            console.log("Foucs in");
            $(this).on("keyup", function(){
                if($(this).val().length)
                    $("#submitComment button").removeAttr("disabled");
                else
                    $("#submitComment button").attr("disabled", "disabled");
            });
        })
        .on("focusout", function(){
            console.log("Foucs out");
            $(this).off("change");
        });

    function submitComment(){
        var commentObj = {};
        commentObj.user = curr_user;
        commentObj.content = $("#submitComment textarea").val();
        var new_comment = $(comment_template(commentObj));
        new_comment.addClass("waiting my-comment");
        new_comment.find("form").prepend(_prev_token);

        if($('#commentsList').hasClass("no-comments"))
            $('#commentsList').removeClass('no-comments');

        $('#commentsList').append(new_comment);

        $("#submitComment button").attr("disabled", "disabled");
        $("#submitComment").addClass("adding-comment");

        var formdata = new FormData($("#submitComment")[0]);
        $.ajax({
              type:'POST',
              url: "/submitComment",
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
            if(response.success){
                var comment = $('#commentsList .a-comment.waiting');
                comment.find("#commentId").val(response.id);
                comment.prop("id", "comment" + response.id);
                comment.find("form").prop("id", "deleteComment" + response.id);
                comment.find("form button").attr("onclick", "deleteComment("+response.id+")");

                setTimeout(function(){
                    comment.removeClass('waiting');
                }, 1200);
                house_details.comment_count += 1;
                updateUi(house_details);
            }else{
                console.log("Failure!, ", response);
                var comment = $('#commentsList .a-comment.waiting');
                comment.css("opacity", 0);
                setTimeout(function(){
                    comment.remove();

                    $("#submitComment textarea").val(commentObj.content);
                    $("#submitComment button").removeAttr("disabled");
                }, 100);
            }
        })
        .fail(function(error){
            console.log("Error!, ", error);
            var comment = $('#commentsList .a-comment.waiting');
            comment.css("opacity", 0);
            setTimeout(function(){
                new_comment.remove();

                $("#submitComment textarea").val(commentObj.content);
                $("#submitComment button").removeAttr("disabled");
            }, 100);
        })
        .always(function(){
            console.log("Action done");
            $("#submitComment").removeClass("adding-comment");
            $("#submitComment textarea").val("");
        });
    }

    function deleteComment(id){
        var el = $("#comment" + id);
        var formdata = new FormData($(el.find("form"))[0]);
        el.addClass('waiting');

        $.ajax({
              type:'POST',
              url: "/deleteComment",
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
            if(response.success){
                el.remove();
                house_details.comment_count -= 1;
                updateUi(house_details);
            }else{
                el.removeClass('waiting');
            }
        })
        .fail(function(response){
            console.log("Response!, ", response);
            el.remove();
        })
        .always(function(){
            console.log("Action done");
        });
    }

    function toggleFav(){
        var formdata = new FormData($("#favoriteHouse")[0]);

        $.ajax({
              type:'POST',
              url: "/favoriteHouse",
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
            if(house_details.faved)
                house_details.fav_count -= 1;
            else
                house_details.fav_count += 1;

            house_details.faved = !house_details.faved;
            updateUi(house_details);
        })
        .fail(function(error){
            console.log("Error!, ", error);
        })
        .always(function(){
            console.log("Action done");
        });
    }

    function updateUi(new_details){
        featured_houses[cur_house] = new_details;
        var ltrailingS = new_details.fav_count == 1 ? "" : "s";
        var likes_text = new_details.fav_count + " like" + ltrailingS;

        var ctrailingS = new_details.comment_count == 1 ? "" : "s";
        var comments_text = new_details.comment_count + " comment" + ctrailingS;

        var house = $("#house"+$('#previewHouseId').val());
        house.find(".social-stuff").text(likes_text+' | '+comments_text);

        $('#previewCommentCount').text(new_details.comment_count);
        $('#previewFavCount').text(new_details.fav_count);

        if(new_details.faved)
          $('#previewReactions').addClass("faved");
        else
          $('#previewReactions').removeClass("faved");

        console.log(new_details.comment_count);
        if(new_details.comment_count < 1){
          $('#commentsList').addClass('no-comments');
        }
    }
</script>