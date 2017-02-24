<div class="image-grid">
    <style>
        body{
            background-color: #eee;
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
            position: fixed;
            top: 0;
            left: 0;
            background: transparent;
            z-index: 9999;

            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;

            -ms-align-items: center;
            align-items: center;
            justify-content: center;

            pointer-events: none;
        }

        #preview .dh-card{
            max-height: calc(96vh - 30px);
            padding: 16px 20px;
            width: 700px;
            overflow: auto;
            border-radius: 10px;
            z-index: 1;
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

        .avatar + .item-text{
            margin-left: 8px;
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
            margin-left: 10px;
            margin-right: 5px;
        }

        .comments .item{
            margin-bottom: 32px;
        }

        .comments textarea{
            border-color: #ccc;
            border-radius: 5px;
            padding: 8px;
        }

        #preview .bg{
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
        }

        #preview .dh-card, #preview .bg{
            opacity: 0;
            pointer-events: none;
        }

        #preview.open .dh-card, #preview.open .bg{
            opacity: 1;
            pointer-events: auto;
        }
    </style>

        <div id="preview" class="--js-house-preview">
            <div class="bg --js-house-preview-bg"></div>
            <div class="dh-card --js-house-preview-card">
                <div class="content">
                    <h3 id="previewTitle">Some header of title</h3>
                    <p id="previewCaption">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse quisquam nemo laboriosam inventore. Dicta ea et aspernatur quibusdam expedita pariatur, dolores assumenda quis nulla architecto. Ullam voluptas, nobis rem eaque.</p>
                    
                    <div class="image"><img id="previewImage" src="{{asset('images/somehouse.jpg')}}" alt=""></div>

                    <div class="layout">
                        <div class="item single-line flex">
                            <div class="avatar">
                                <img id="previewUserdp" src="{{asset('images/users/ludoya.jpg')}}" alt="">
                            </div>

                            <div class="item-text">
                                <div id="previewUsername" class="title">Ludoya Francis</div>
                            </div>
                        </div>

                        <span class="layout center-center reactions">
                            <svg fill="#E91E63" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg> <span id="previewFavCount">45</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg> <span id="previewCommentCount">3</span>
                        </span>
                    </div>

                    <hr>

                    <div class="comments">
                        <!-- <div class="item flex">
                            <div class="avatar">
                                <img src="{{asset('images/users/imelda.jpg')}}" alt="">
                            </div>

                            <div class="item-text">
                                <div class="title">Sauda Miango</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos delectus velit atque, possimus. Autem esse, cupiditate nam magnam. Quis officia eius, voluptatem dolorum rem enim exercitationem eum distinctio, illum aliquam?</p>
                            </div>
                        </div> -->

                        <div class="empty-message">No comments</div>

                        @if (Auth::user())
                            <div class="item flex">
                                <div class="avatar">
                                    <?php 
                                        $user = Auth::user();
                                    ?>
                                    <img src='{{asset("images/uploads/$user->dp")}}' 
                                    alt="{{$user->fname}}'s dp">
                                </div>

                                <textarea class="item-text flex" placeholder="Your comment" name="" rows="5"></textarea>
                            </div>

                            <button style="float: right; margin-top: -10px; display: inline-block;" class="btn btn-primary">Submit</button>
                        @else
                            <div class="empty-message"><a href="/login">Login</a> to comment</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


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