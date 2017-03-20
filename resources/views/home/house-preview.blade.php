<div id="preview" class="--js-house-preview">
    <button class="closer --js-house-preview-closer">
        <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>
    <div class="dh-card --js-house-preview-card">
        <div class="content">
            <h3 id="previewTitle">Some title</h3>
            <p id="previewCaption">Lorem.</p>
            
            <div id="previewImageHolder" class="image"><img style="min-height: 300px;" id="previewImage" src="{{asset('/')}}" alt=""></div>

            <div class="layout">
                <div class="item single-line flex">
                    <div class="avatar">
                        <img id="previewUserdp" src="{{asset('/')}}" alt="">
                    </div>

                    <div class="item-text">
                        <div class="title">
                            <a id="previewUsername">
                                Ludoya Francis
                            </a>
                        </div>
                    </div>
                </div>

                <span id="previewReactions" class="layout center-center reactions faved">
                    <form id="favoriteHouse" action="/favoriteHouse" method="POST">
                        {{ csrf_field() }}
                        <input class="previewHouseId" type="hidden" name="house_id">

                        <button type="button" class="fav-icon unfaved" onclick="toggleFav()">
                            <svg fill="#333" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg>
                        </button>

                        <button type="button" class="fav-icon faved" onclick="toggleFav()">
                            <svg fill="#E91E63" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                    </form>
                    <span id="previewFavCount"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg> <span id="previewCommentCount"></span>
                </span>
            </div>

            <hr>

            <div id="previewComments" class="comments">
                <div id="commentsList" class="no-comment">
                    <div class="empty-message">No comments</div>
                </div>
                <div id="loadingComments" class="empty-message">
                Loading comments</div>
                
                @if (Auth::user())
                    <form id="submitComment" action="{{ url('/submitComment') }}" method="POST">
                        {{ csrf_field() }}
                        <input id="previewHouseId" class="previewHouseId" type="hidden" name="house_id">

                        <div class="item flex">
                            <div class="avatar">
                                <?php 
                                    $user = Auth::user();
                                ?>
                                <img src='{{asset($user_url . $user->dp)}}' 
                                alt="{{$user->fname}}'s dp">
                            </div>

                            <textarea class="item-text flex" placeholder="Your comment" name="content" rows="5"></textarea>
                        </div>

                        <button type="button" disabled onclick="submitComment()" style="float: right; margin-top: -10px; display: inline-block;" class="btn btn-primary">Submit</button>
                    </form>
                @else
                    <div class="empty-message"><a href="/login">Login</a> to comment</div>
                @endif
            </div>
        </div>
    </div>
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
        commentObj.user = cur_user;
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