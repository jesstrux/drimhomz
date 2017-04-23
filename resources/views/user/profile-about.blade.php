<style>
    #newAboutOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newAboutOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
	    overflow: hidden;
	    overflow-y: auto;
    }

    #newAboutOuter #dpOuter:not(.saving) .layout{
        opacity: 0 !important;
        pointer-events: none !important;
    }

    .table-ish{
	    text-align: left;
	    font-size: 15px;
	    padding: 10px 0;
	    font-family: Verdana, Geneva, sans-serif;
	    font-weight: 400;
    }
    .table-ish > div{
	    margin-bottom: 10px;
	    align-items: center;
    }
    .table-ish > div > div:last-child{
	    font-size: 22px;
        -webkit-flex: 1;
        -moz-flex: 1;
        -ms-flex: 1;
        -o-flex: 1;
        flex: 1;
    }
    .table-ish > div > div:first-child{
	    margin-right: 30px;
	    width: 35%;
	    min-width: 35%;
	    text-align: center;
	    font-weight: 300;
    }

    @media only screen and (max-width: 760px) {
        #newAboutOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
	        height: calc(100vh - 22px);
        }
    }
</style>
<div id="newAboutOuter" class="cust-modal ope">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px; background-colo: #ee9900">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeAbout()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">
	            About
            </h5>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative; margin-top: -4px; text-align: center; padding-left: 0; padding-right: 0;">
        <div id="dpOuter" style="position: relative; display: inline-block; border-radius: 50%; overflo: hidden;">
            <img src="{{$user_url . $user->dp}}" alt="{{$user->fname}}'s picture" id="temp-dp" class="a-dp" style="width: 170px; height: 170px; border-radius: 50%; background-color: #ddd" onclick="openNewPicture(event)">

            <div class="layout center-center" style="background-color: rgba(5,5,5,0.5); position: absolute; top: 0; left: 0;width: 100%; height: 100%;">
                <img src="{{asset("images/loading.gif")}}" alt="loading..." style="width: 60px;">
            </div>
        </div>

	    <div>
		    <h3 style="margin: 25px 0; margin-bottom: 45px; font-size: 1.7em">
			    {{$user->full_name()}}
		    </h3>
		    <hr style="border-color: #dedede">

		    <div style="paddin: 0 20px;">
			    <div class="layout vertical table-ish">
				    <div class="layout" style="">
					    <div>PHONE :</div>
					    <div>{{$user->phone}}</div>
				    </div>
				    @if($myProfile || ($user->role != "admin" && $user->role != "user"))
					    <div class="layout">
						    <div>EMAIL :</div>
						    <div>
							    @if($user->email)
								    {{$user->email}}
							    @else
								    Unknown
							    @endif
						    </div>
					    </div>
					    <div class="layout">
						    <div>STREET :</div>
						    <div>
							    @if($user->street)
								    {{$user->street}}
							    @else
								    Unknown
							    @endif
						    </div>
					    </div>
					    <div class="layout">
						    <div>TOWN :</div>
						    <div>
							    @if($user->town)
								    {{$user->town}}
							    @else
								    Unknown
							    @endif
						    </div>
					    </div>
				    @endif
			    </div>
		    </div>
	    </div>
    </div>
</div>

@include('user.profile-picture')

<script>
    var org_pic, tempImage;
    function closeAbout() {
        $("#newAboutOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#newAboutTitle").val("");
    }

    function openAbout(e) {
        $("#newAboutOuter").addClass("open");
        $("#newAboutTitle").focus();
        $("body").addClass("locked");

        var previewCard = $("#temp-dp").get(0);
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
//        previewCard.style.transformOrigin = previewCard.style.webkitTransformOrigin = "50% 50%";
	    previewCard.style.transformOrigin = previewCard.style.webkitTransformOrigin = "0";

        var animation = previewCard.animate([
            {opacity: 0, transform: translate + "scale(0)"},
            {opacity: 1.0, transform: "none"}
        ], {
            duration: 170,
	        fill: 'forwards'
        });
    }
</script>