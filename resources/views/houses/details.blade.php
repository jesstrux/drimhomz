<div class="dh-card" style="width:100%;max-width: 700px; transform: none; opacity: 1; padding: 30px; margin: 45px auto;">
    <div class="content">
        <h3 id="previewTitle">{{$house->title}}</h3>
        <p id="previewCaption">{{$house->description}}</p>
        
        <div id="previewImageHolder" class="image"><img style="min-height: 300px; max-height: 450px" id="previewImage" src="{{asset($house_url.$house->image_url)}}" alt=""></div>

        <div class="layout">
            <div class="item single-line flex">
                <div class="avatar">
                    <img id="previewUserdp" src="{{asset($user_url . $house->owner()->dp)}}" alt="">
                </div>

                <div class="item-text">
                    <div class="title">
                        <a id="previewUsername">
                            {{$house->owner()->fname . " " . $house->owner()->lname}}
                        </a>
                    </div>
                </div>
            </div>

            <span id="previewReactions" class="layout center-center reactions faved">
                <form id="favoriteHouse" action="/favoriteHouse" method="POST">
                    {{ csrf_field() }}
                    <input class="previewHouseId" type="hidden" name="house_id" value="{{$house->id}}">

                    <button type="button" class="fav-icon unfaved" onclick="toggleFav()">
                        <svg fill="#333" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg>
                    </button>

                    <button type="button" class="fav-icon faved" onclick="toggleFav()">
                        <svg fill="#E91E63" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </button>
                </form>
                <span>
                    {{$house->favorites->count()}}
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg> <span>
                    {{$house->comments->count()}}
                </span>
            </span>
        </div>

        <hr>

        <div class="comments">
            <div id="commentsList" class="no-comment">
                <div class="empty-message">No comments</div>
            </div>
            <div id="loadingComments" class="empty-message">
            Loading comments</div>
            
            @if (Auth::check())
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