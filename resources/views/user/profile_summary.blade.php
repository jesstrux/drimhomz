                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <style>
    #followBtn{
        outline: none !important;
    }
    #followBtn:not(.followed){
        background-color: #f3f3f3;
        border: 2px solid #ccc;
    }
    #followBtn:not(.followed) svg{
        fill: #555;
    }
    .lg-followed{
        background-color: #ffa500; color: #f1eee9;
        /*pointer-events: none;*/
    }
    .lg-followed.lg-followed:hover{
        background-color: #f1a00b;color: #f1eee9;
    }
    .lg-followed.lg-followed:focus{
        background-color: #f1a00b;color: #f1eee9;
    }
    #followBtnLg span{
        text-transform: uppercase;
    }
    #followBtnLg:not(.lg-followed) span:nth-child(2){
        display: none;
    }

    #followBtnLg.lg-followed span:nth-child(1){
        display: none;
    }

    #profileSummary{
        /*margin-bottom: 5px;*/
    }

    #profileSummary .tabhead{
        color: inherit;
        text-decoration: none;
    }

    #profileSummary .tabhead.active{
        /*display: none;*/
    }

    #becomeExpertModal .cust-modal-content{
        border-radius: 3px;
        width: 400px !important;
    }

    @media only screen and (max-width: 760px) {
        #becomeExpertModal .cust-modal-content{
            border-radius: 0;
            width: 100vw !important;
            padding: 20px;
        }
        #profileSummary .tabhead{
	        min-width: calc(37% - 4px);
        }
    }
</style>

<div id="profileSummaryLg" class="col-sm-12 col-md-4">
    <div id="userDetails" class="text-center">
        <div id="profilePic" style="background: #ddd;">
            <img src='{{asset($user_url . $user->dp)}}'
                 alt="{{$user->fname}}'s dp" class="a-dp">
        </div>
        <h3>{{$user->full_name()}}</h3>

        @if(!$myProfile)
            <p style="padding: 5px 30px;">

                @if(isset($user->town) )  <b>From:</b>{{$user->town}} <br>@endif
                @if($user->hasRole('expert'))
                    <b>Expertise:</b> {!! isset($user->skills)? $user->skills : 'No Expert skills' !!}
                @endif
            </p>
        @else
            <br>
        @endif

        @if($myProfile)
            <a href="/setupAccount" class="btn btn-default">
                Edit profile
            </a>&nbsp;

            @if(!$user->hasRole('expert'))
                <button class="btn btn-default" onclick="openBecomeExpert()">
                    Become Expert
                </button>
            @endif

            @if(!$user->hasRole('seller'))
                <button class="btn btn-default" onclick="openBecomeSeller()">
                    Become A Seller
                </button>
            @endif
        @else
            @if(!Auth::guest())
                <form id="followUserForm" method="POST" action="{{ url('/followUser') }}" onsubmit="followThisUser(event)">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$user->id}}">

                    <button id="followBtnLg" type="submit" class="btn btn-default lg-{{$followed_str}}">
                        <span>follow</span>
                        <span>followed</span>
                    </button>
                </form>
            @endif
        @endif
                        <!-- <hr> -->
    </div>
</div>

<div id="profileSummary" class="col-sm-12 col-md-4" style="background: #fff; padding-top: 5px; padding-bottom: 3px; text-align: cente;margin-top: -12px;">

    <div class="layout center">
        <div style="position: relative;width: 110px; height: 110px; margin: 20px 16px;" >
            <div class="a-dp-bg" onclick="openAbout(event)" style="height: 100%; width: 100%; border-radius: 50%; overflow: hidden;background-color: #ddd; background-position: top center; -webkit-background-size: cover;background-size: cover; background-image: url({{asset($user_url . $user->dp)}})">
            </div>

            @if(!Auth::guest())
                @if(!$myProfile)
                    <button style="position: absolute; bottom: -12px; right: -12px" id="followBtn"
                            class="{{$followed_str}}"
                            onclick="followThisUser()">
                        <svg fill="#000000" height="30" viewBox="0 0 24 24" width="30" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </button>
                @endif
            @endif
        </div>

        <div class="layout vertical flex" style="font-size: 2em; padding: 0 10px; padding-top: {{$myProfile ? "26px;" : ""}}">
            <span id="name">{{$user->fname}}</span>
            <span id="name">{{$user->lname}}</span>
            @if($user->town)
                <span style="font-size: 17px"><b>From:</b> {{$user->town}}</span>
            @endif
            {{--@if($myProfile && $user->hasRole('user'))--}}
            {{--<button class="btn btn-default" onclick="openBecomeExpert()" style="margin-top: 10px; margin-bottom: 20px;">--}}
            {{--Become Expert--}}
            {{--</button>--}}
            {{--@endif--}}
        </div>
    </div>

    <div class="tabheads the-tab-heads" style="margin-top: -6px; margin-bottom: 4px;">
        @if($user->hasRole(['expert','realtor','seller']))
            <nav class="tab-shifters">
                <a class="{{$page_parent == 'user' ? 'active' : ''}}" href="javascript:void(0);" onclick="shiftTabs('user')">AS USER</a>
                <a class="{{$page_parent == 'expert' ? 'active' : ''}}" href="javascript:void(0);" onclick="shiftTabs('expert')">AS EXPERT</a>
            </nav>

        @else
            <div style="height: 10px;"></div>
        @endif

        <div class="the-tabs-scroll {{'show-' . $page_parent. '-options'}}">
            <div class="layout justified for-user">
                <a href="/user/{{$user->id}}/projects" data-target="projects" class="tabhead {{is_curpage($page, 'projects')}}"><span>{{$project_count}}</span><span>PROJECTS</span></a>

                <a href="/user/{{$user->id}}/houses" data-target="houses" class="tabhead {{is_curpage($page, 'houses')}}"><span>{{$house_count}}</span><span>DREAMS</span></a>

                <a href="/user/{{$user->id}}/following" data-target="following" class="tabhead {{is_curpage($page, 'following')}}"><span>{{$following_count}}</span><span>FOLLOWING</span></a>

                <a href="/user/{{$user->id}}/followers" data-target="followers" class="tabhead {{is_curpage($page, 'followers')}}"><span class="follower_count">{{$followers_count}}</span><span>FOLLOWERS</span></a>
            </div>
            <div class="layout justified for-expert">
                @role(['expert','realtor','seller'])
                    <a href="/user/{{$user->id}}/articles" data-target="articles" class="tabhead {{is_curpage($page, 'articles')}}"><span>{{$articles_count}}</span><span>ARTICLES</span></a>

                    <a href="/user/{{$user->id}}/reviews" data-target="reviews" class="tabhead {{is_curpage($page, 'reviews')}}"><span>{{$reviews_count}}</span><span>REVIEWS</span></a>
                @endrole

                @role('seller')
                    <a href="/user/{{$user->id}}/shops" data-target="shops" class="tabhead {{is_curpage($page, 'shops')}}"><span>{{$shops_count}}</span><span>SHOPS</span></a>
                @endrole

                <a href="/user/{{$user->id}}/followers" data-target="followers" class="tabhead {{is_curpage($page, 'followers')}}"><span class="follower_count">{{$followers_count}}</span><span>FOLLOWERS</span></a>
            </div>
        </div>
    </div>

    <h5 style="text-align: center; font-weight: bold; font-size: 1.2em; text-transform: uppercase; padding-left: 12px; margin: 7px 0; margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">{{$page}}</h5>
</div>

<div id="becomeExpertModal" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeBecomeExpert()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">Become Expert</h5>

            <button onclick="event.preventDefault();
                                 document.getElementById('becomeExpert').submit();" class="btn save-new-project" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SUBMIT
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeBecomeExpert()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="becomeExpert" method="POST" action="/becomeExpert" onsubmit="checkValidity(event, this)">
                <h3 class="hidden-xs">Become Expert</h3>
                <p>Please fill in some extra information below, you can select more than one expertise</p>

                {{csrf_field()}}
                <label>Skills</label>
                <select name="skill[]" multiple required style="padding: 8px 4px;border: 1px solid #999 !important">
                    <option value="Architect">Architect</option>
                    <option value="Interior Designer">Interior Designer</option>
                    <option value="Mason">Mason</option>
                    <option value="Preemptive Strategist">Preemptive Strategist</option>
                    <option value="Quantity Surveyor">Quantity Surveyor</option>
                    <option value="Town Planner">Town Planner</option>
                </select>

                <label>Office Name</label>
                <input autocomplete="off" name="office_name" type="text" placeholder="eg. AQ Surveyors" required style="font-size: 1.5em; margin-bottom: 40px;">

                <button type="submit" class="btn btn-primary save-new-project hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn">SUBMIT</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to become an expert.</p>
        @endif
    </div>
</div>

<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script>
    var is_followed = <?php echo $is_followed ?: 0 ?>;
    var followers_count = <?php echo $followers_count ?>;
    $("#becomeExpert").validate();

    function followThisUser(e){
//	    return;
	    if(e){
		    e.preventDefault();
	    }

	    var form = $("#followUserForm");
        var formdata = new FormData(form[0]);

        $.ajax({
            type:"POST",
            url: form.attr("action"),
            data: formdata,
            dataType:"json",
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
            if(response.success){
//	            showToast("success", response.msg + ", now has " + response.followers_count);

                $('.follower_count').text(response.followers_count);
                $("#followBtnLg").toggleClass('lg-followed');
                $("#followBtn").toggleClass('followed');
            }else{
	            showToast("error", response.msg);
            }
        })
        .fail(function(response){
//            document.write(response.responseText);
            console.log("Response!, ", response);
	        showToast("error", "Unknown error occure");
        })
        .always(function(){
            console.log("Action done");
        });
    }

    function editProfile(url){
        var formdata = new FormData($("#editProfile")[0]);
        $.ajax({
            type:'POST',
            url: url,
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
        })
        .fail(function(response){
            console.log("Response!, ", response);
        })
        .always(function(){
            console.log("Action done");
        });
    }

    function openBecomeExpert(){
        $("#becomeExpertModal").addClass("open");
        $("body").addClass("locked")
    }

    function closeBecomeExpert(){
        $("#becomeExpertModal").removeClass("open");
        $("body").removeClass("locked")
    }

    function checkValidity(event, form){
        if(!$(form).valid()){
            event.preventDefault();
            alert("Not cool man!");
        }
    }
</script>