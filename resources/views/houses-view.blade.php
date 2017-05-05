@extends('layouts.app')

@section('content')
    <input id="nextPageInput" type="hidden" value="{{json_encode(["has_more" => $houses->hasMorePages(), "next_page" => (int) str_replace("page=", "", substr($houses->nextPageUrl(), strpos($houses->nextPageUrl(), "page=")))])}}">
	@include('layouts.header')

    <ul id="container">
        @include('houses-list')
    </ul>

	<script src="{{asset('js/wookmark.min.js')}}"></script>
	<script src="{{asset('js/imagesLoaded.min.js')}}"></script>
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
				featured_houses = featured_houses ||  [],
				first_load = true;

            $document.ready(function(){
                var more_options = JSON.parse($("#nextPageInput").val());
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
                        timings.delay = ($self.index() % 5) * 108;

                        timings.duration = 250;

                        var transform_len = parseInt(20 * $self.index() / 5) + '%';

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
                    console.log(response);

                    if(houses && houses.length){
                        $container.append(houses);
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
	</script>
@endsection