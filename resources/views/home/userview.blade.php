<script>
    function comment_template(commentObj) {
        if(!commentObj.id)
            commentObj.id = "";

        comment = '';
        comment += '<div id="comment'+commentObj.id+'" class="a-comment item flex">';
        comment += '    <div class="avatar">';
        comment += '        <img src="images/uploads/'+commentObj.user.dp+'" alt="'+commentObj.user.fname+'s dp">';
        comment += '    </div>';
        comment += '    <div class="item-text">';
        comment += '        <div class="title">'+commentObj.user.fname+ ' ' + commentObj.user.lname+'</div>';
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

    var _token = '<input type="hidden" name="_token" value="'+ '<?php echo csrf_token(); ?>' +'">';
</script>
<div class="image-grid">
    <style>
        body{
            background-color: #eee;
            /*overflow: hidden;*/
        }
        body.locked{
            overflow: hidden;
        }
        .image{
            pointer-events: none;
        }
        #container{
            list-style: none;
            display: block;
            position: relative;
            padding: 0;
            margin: 0;
        }
        #container .grid-sizer, #container .dh-card{
            width: calc(20% - 10px);
            /*background-color: red;*/
            /*display: block;*/
            opacity: 0;

            -webkit-transition: opacity 0.15s ease-out;
            -o-transition: opacity 0.15s ease-out;
            transition: opacity 0.15s ease-out;
        }
        #container .dh-card{
            display: inline-block;
            margin: 0 5px; margin-bottom: 15px; border-radius: 10px;
            margin: 0;
        }

        #container .dh-card .image{
            border-radius: 10px 10px 0 0;
        }

        @media all and (max-width: 900px) {
            #container .grid-sizer, #container .dh-card{
                width: calc(33.333% - 10px);
            }
        }

        @media all and (max-width: 768px) {
            #container .grid-sizer, #container .dh-card{
                width: calc(50% - 10px);
            }
        }

        @media all and (max-width: 406px) {
            #container .grid-sizer, #container .dh-card{
                width: calc(100% - 10px);
            }
        }

        .dh-card p{
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            -ms-text-overflow: ellipsis;
            text-overflow: ellipsis;
        }
        .api-message{
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            opacity: 0;
            pointer-events: none;
            color: #999;
        }
        .api-message.open{
            opacity: 1;
            pointer-events: auto;
        }

        #preview{
            width: 100vw;
            height: 100vh;
            max-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            overflow: hidden;
            pointer-events: none;
            background-color: transparent;
        }
        #preview.open{
            pointer-events: auto;
            overflow-y: auto;
            background-color: #333;
            background-image: -webkit-linear-gradient(#222, #333);
            background-image: -o-linear-gradient(#222, #333);
            background-image: linear-gradient(#222, #333);
        }
        #preview .closer{
            position: fixed;
            top: 20px;
            right: 50px;
            width: 30px;
            height: 30px;
            background-color: green;
        }

        #preview .dh-card, #preview .closer{
            opacity: 0;
            pointer-events: none;
        }

        #preview .dh-card{
            /*max-height: calc(96vh - 30px);*/
            padding: 16px 20px;
            width: 680px;
            border-radius: 10px;
            z-index: 1;
            position: relative;
            margin: 35px auto;
            padding-bottom: 40px;
            /*overflow: auto;*/
        }

        #preview.open .dh-card, #preview.open .closer{
            opacity: 1;
            pointer-events: auto;
        }

        #preview .dh-card p{
            white-space: normal;
        }

        #preview .image{
            /*max-width: 500px;*/
            margin: 20px 0;
            /*max-height: 350px;*/
            border-radius: 5px;
        }

        .item{
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
        }

        .item.single-line{
            -ms-align-items: center;
            align-items: center;
        }

        .item .item-text{
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;

            -webkit-flex-direction: column;
            -moz-flex-direction: column;
            -ms-flex-direction: column;
            -o-flex-direction: column;
            flex-direction: column;

            font-size: 14px;
            color: #333;
        }

        .item-text .title{
            /*font-size: 17px;*/
            color: #000;
            font-weight: bold;
        }

        .item:not(.single-line) .item-text .title{
            margin: 6px 0;
        }

        .avatar + .item-text{
            margin-left: 18px;
        }

        .avatar, .avatar img{
            border-radius: 50%;
            height: 40px;
            width: 40px;
            min-width: 40px;
            overflow: hidden;
        }

        #preview .dh-card hr {
            /*margin-top: 8px;*/
            border:none;
            border-bottom: 1px solid #eee;
        }

        #preview .dh-card .item .title{
            font-family: Raleway,sans-serif;
        }

        .reactions svg{
            margin-left: 20px;
            margin-right: 10px;
        }

        .fav-icon svg{
            margin-left: 3px;
            margin-right: 3px;
            margin-top: 4px;
        }

        .fav-icon{
            background-color: transparent;
            border: none;
            padding-right: 6px;
            padding-left: 6px;
        }

        .reactions.faved form .fav-icon.unfaved{
            display: none;
        }

        .reactions:not(.faved) form .fav-icon.faved{
            display: none;
        }

        .comments{
            -webkit-transition: all 0.35s ease-out;
            -o-transition: all 0.35s ease-out;
            transition: all 0.35s ease-out;
        }

        .comments .item{
            margin-bottom: 32px;
        }

        .a-comment{
            position: relative;
            -webkit-transition: opacity 0.35s ease-out;
            -o-transition: opacity 0.35s ease-out;
            transition: opacity 0.35s ease-out;
        }

        .a-comment.waiting{
            opacity: 0.5;
        }

        .a-comment form{
            position: absolute;
            right: 0;
            top: 0;
        }

        .a-comment.waiting form{
            opacity: 0;
            pointer-events: none;
        }

        .a-comment form button{
            background-color: transparent;
            border: none;
            padding: 6px;
            color: #000;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .comments textarea{
            border-color: #ccc;
            border-radius: 5px;
            padding: 8px;
        }

        #commentsList .empty-message{
            margin-bottom: 18px;
        }

        #commentsList:not(.no-comments) .empty-message{
            display: none;
        }

        .comments:not(.loading) #loadingComments{
            display: none;
        }

        #submitComment.adding-comment > textarea,
        #submitComment.adding-comment > button{
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
        @include('home.house-preview')
        <ul id="container"></ul>

        <!-- <div class="empty-message">There are no featured houses.</div> -->
        <div style="position: relative; height: 50px; margin-bottom: 30px;">
            <div id="loaderMessage" class="empty-message api-message">Loading....</div>
            <div id="noMoreMessage" class="empty-message no-more-message api-message">No more houses</div>
        </div>
</div>

<script src="{{asset('js/wookmark.min.js')}}"></script>
<script src="{{asset('js/imagesLoaded.min.js')}}"></script>
<script src="{{asset('js/houses-loader.js')}}"></script>