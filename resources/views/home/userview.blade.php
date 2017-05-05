<script>
    function comment_templater(commentObj) {
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
        comment += '        <p class="comment-content">'+commentObj.content+'</p>';
        comment += '    </div>';
        comment += '    <div class="form-things layout">';
        comment += '    <a type="button" class="comment-editor" style="cursor: pointer" onclick="editComment('+commentObj.id+')">';
        comment += '        <i class="fa fa-pencil" title="edit"></i>';
        comment += '    </a>';
        comment += '    <form id="deleteComment'+commentObj.id+'" action="deleteComment" method="POST">';
        comment += '        <input id="commentId" type="hidden" value="'+commentObj.id+'" name="id">';
        comment += '        <a type="button" style="cursor: pointer" onclick="deleteComment('+commentObj.id+')">'
        comment += '            <i class="fa fa-trash" title="Delete"></i>';
        comment += '        </a>';
        comment += '    </form>';
        comment += '    </div>';
        comment += '</div>';

        return comment;
    }

    function tangazo_tpl(ad){
        html  = '<li class="tangazo dh-card grid-item">';
        html +=   '<div class="image">';
        html +=     '<a style="display: block"><img src="' + ad_base_url + ad.image_url+'" alt="'+ad.title+'"></a>';
        html +=   '</div>';
        html += '</li>';

        return html;
    }

    var _token = '<input type="hidden" name="_token" value="'+ '<?php echo csrf_token(); ?>' +'">';

    var cur_user = <?php echo Auth::guest() ?: Auth::user(); ?>;
    // var cur_user = JSON.parse(cur_user_obj);
    var random_ads = <?php echo isset($random_ads) ? $random_ads : json_encode(array())  ?>;
</script>

@if(!Auth::guest())
    {{--<div id="fab-wrapper">--}}
    {{--<div class="scrim" onclick="closeFabs()">--}}

    {{--</div>--}}
    {{--<div class="layout vertical center" style="position: fixed; right: 20px; bottom: 20px;">--}}
    {{--<button class="a-fab sm" onclick="openNewHouseClick()">--}}
    {{--<i class="fa fa-home"></i>--}}
    {{--</button>--}}
    {{--<button class="a-fab sm" onclick="openNewProjectClick()">--}}
    {{--<i class="fa fa-briefcase"></i>--}}
    {{--</button>--}}
    {{--<button class="a-fab lg" onclick="toggleFabs()">--}}
    {{--<i class="fa fa-plus"></i>--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div>--}}
@endif

<input id="nextPageInput" type="hidden" value="{{json_encode(["has_more" => $houses->hasMorePages(), "next_page" => (int) str_replace("page=", "", substr($houses->nextPageUrl(), strpos($houses->nextPageUrl(), "page=")))])}}">
<div class="image-grid">
    <ul id="container">
        @include('houses-list')
    </ul>

    <!-- <div class="empty-message">There are no featured houses.</div> -->
    <div style="position: relative; height: 50px; margin-bottom: 30px;">
        <div id="loaderMessage" class="empty-message api-message">Loading....</div>
        <div id="noMoreMessage" class="empty-message no-more-message api-message">No more dreams</div>
    </div>
</div>

<script src="{{asset('js/wookmark.min.js')}}"></script>
<script src="{{asset('js/imagesLoaded.min.js')}}"></script>
{{--<script src="{{asset('js/houses-loader.js')}}"></script>--}}

<script>
    showLoading();

    (function ($) {
        var wookmark = undefined,
            page = 1,
            isLoading = false,
            apiURL = '',
            nextPageIdx = null,
            lastRequestTimestamp = 0,
            fadeInDelay = 2000,
            container = '#container',
            $container = $(container),
            $loaderMessage = $('#loaderMessage'),
            $noMoreMessage = $('#noMoreMessage'),
            $window = $(window),
            $document = $(document),
            cur_idx_left = 0,cur_idx_right = 1,
//            featured_houses = featured_houses ||  [],
            first_load = true;

        $document.ready(function(){
            var more_options = JSON.parse($("#nextPageInput").val());
            featured_houses = <?php echo json_encode($houses_json); ?>;
            console.log(more_options);
            applyLayout();
            if(more_options.has_more){
                $document.on('scroll', onScroll);
                apiURL = "/randomFeaturedHouses?page=" + more_options.next_page;
            }
        });

        /**
         * When scrolled all the way to the bottom, add more tiles.
         */
        function onScroll(event) {
            // Only check when we're not still waiting for data.
            if (!isLoading) {
                // Check if we're within 100 pixels of the bottom edge of the broser window.
                var closeToBottom = ($window.scrollTop() + $window.height() > $document.height() - 100);
                if (closeToBottom) {
                    // Only allow requests every second
                    var currentTime = new Date().getTime();
                    if (lastRequestTimestamp < currentTime - 1000) {
                        lastRequestTimestamp = currentTime;
                        loadData();
                    }
                }
            }
        }

        /**
         * Refreshes the layout.
         */
        function applyLayout(){
            var timings = {
                fill: 'forwards',
                easing: 'ease-out'
            };

            imagesLoaded(container, function () {
                hideLoading();
                // Destroy the old handler
                if (wookmark === undefined) {
                    wookmark = new Wookmark(container, {
                        offset: 10
                    });
                } else {
                    wookmark.initItems();
                    wookmark.layout(true);
                }

                window.setTimeout(function(){
                    isLoading = false;
                    $loaderMessage.removeClass("open");
                }, fadeInDelay + 300);

                $container.find(".a-new-house").each(function () {
                    var $self = $(this);
                    $self.removeClass('a-new-house');
                    var el = $self.get(0);
//                        window.setTimeout(function () {
//                            $self.css('opacity', 1);
//                        }, Math.random());
//                        timings.delay = ($self.index() - ($self.index() / 5) * 5  % 5) * 108 * ($self.index() / 5);
                    var family_count = 2;
                    if(window.innerWidth < 600)
                        family_count = 2;
                    else if(window.innerWidth > 600 && window.innerWidth < 1000)
                        family_count = 4;
                    else if(window.innerWidth > 1000)
                        family_count = 5;

                    timings.delay = ($self.index() % family_count) * 108;

                    timings.duration = 250;

                    var transform_len = parseInt(20 * $self.index() / family_count) + '%';

                    el.animate([
                        { transform: 'translateY('+transform_len+')', opacity: 0 },
                        { transform: 'translateY(0)', opacity: 1 }
                    ], timings);


                    timings.duration = 500;
//                        timings.delay = (($self.index() + 1)  % 6) * 108;

                    el.animate([
                        {opacity: 0},
                        {opacity: 1}
                    ], timings);
                });

                var a = document.querySelectorAll('div');

                $(".user-link").each(function(){
                    $(this).webuiPopover({
                        type:'async',
                        trigger:'hover',
                        url:'/userProfilePopup/'+$(this).data('user-id')
                    });
                })
            });
        }

        /**
         * Loads data from the API.
         */
        function loadData() {
            if(!$(container).length)
                return;

            showLoading();
            $.ajax({
                url: apiURL,
                type: 'GET',
                dataType: 'json'
            })
                .done(function(response) {
                    var houses = response.houses;
                    apiURL = response.next_page_url;
//                    console.log(response);
                    featured_houses = featured_houses.concat(houses);

                    if(houses && houses.length){
                        $container.append(response.houses_html);
                        showLoading();
                        applyLayout();
                    }
                    if(!response.has_more){
                        $document.off('scroll', onScroll);
                        $noMoreMessage.addClass("open");
                    }
                })
                .fail(function(error) {
                    console.log(error);
                })
                .always(function() {
//					console.log("Data loaded!");
                    hideLoading();
                });
        }

        function getAd(i){
            if(random_ads && random_ads.length)
                return tangazo_tpl(random_ads[i]);
            else
                return "";
        }

        function activateAds(){
            setInterval(function(){
                cur_idx_left = cur_idx_left+2 > random_ads.length - 1 ? 0 : cur_idx_left+2;
                setAd($(".tangazo:first"), random_ads[cur_idx_left]);
            }, 3000);

            setTimeout(function(){
                setInterval(function(){
                    cur_idx_right = cur_idx_right + 2 > random_ads.length - 1 ? 1 : cur_idx_right + 2;
                    setAd($(".tangazo:last"), random_ads[cur_idx_right]);
                }, 3000);
            }, 1800);
        }

        function setAd(el, ad){
            el.find("a").prop("href", ad.link);
            el.find("img").prop({src: ad_base_url + ad.image_url, alt: ad.title});
        }
    })(jQuery);

    function followHouse(id){
        showLoading();
        var form = $("#followHouse"+id);
        var formdata = new FormData(form[0]);
        var el = form.find(".follow-house-btn");
        formdata.append("house_id", id);
        formdata.append("_token", Laravel.csrfToken);

        $.ajax({
            type:'POST',
            url: "/followHouse",
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
            .done(function(response){
                console.log("Response!, ", response);
                if(response.success){
                    closeNewPin();
                    showToast("success", response.msg);

                    if(el.hasClass("followed")){
                        el.text("FOLLOW");
                    }else{
                        el.text("UNFOLLOW");
                    }

                    el.toggleClass("followed");
                }else{
                    showToast("error", response.msg);
                }
            })
            .fail(function(response){
                console.log("Error!, ", response);
                showToast("error", "An unknown error Occured");
            })
            .always(function(){
                console.log("Action done");
                hideLoading();
            });
    }

    function toggleFabs(){
        var fabWrapper = $("#fab-wrapper");
        if(!fabWrapper.hasClass("open")){
            fabWrapper.addClass("open");
        }else{
            fabWrapper.removeClass("open");;
        }
    }

    function closeFabs(){
        var fabWrapper = $("#fab-wrapper");
        if(fabWrapper.hasClass("open")){
            fabWrapper.removeClass("open");
        }
    }

    function openNewProjectClick(){
        closeFabs();
        openNewProject()
    }

    function openNewHouseClick(){
        closeFabs();
        openNewHouse()
    }
</script>