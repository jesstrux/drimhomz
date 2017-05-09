<style>
    #rateItOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }

    #rateItOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
        width: 300px;
        overflow: hidden;
        overflow-y: auto;
        padding-bottom: 15px;
    }

    #rateItOuter .cust-modal-content.rotated{
        -webkit-transform: rotateY(180deg) perspective(500px);
        -moz-transform: rotateY(180deg) perspective(500px);
        -ms-transform: rotateY(180deg) perspective(500px);
        -o-transform: rotateY(180deg) perspective(500px);
        transform: rotateY(180deg) perspective(500px);

        -webkit-transition: transform 0.35s ease-out;
        -moz-transition: transform 0.35s ease-out;
        -ms-transition: transform 0.35s ease-out;
        -o-transition: transform 0.35s ease-out;
        transition: transform 0.35s ease-out;
    }

    #rateItOuter .cust-modal-content.rotated .rater-title span:first-child,
    #rateItOuter .cust-modal-content.rotated .rate-expert{
        display: none;
    }

    #rateItOuter .cust-modal-content:not(.rotated ) .rater-title span:last-child,
    #rateItOuter .cust-modal-content:not(.rotated ) textarea,
    #rateItOuter .cust-modal-content:not(.rotated ) .save-rate-expert.save-rate-expert,
    #rateItOuter .cust-modal-content:not(.rotated ) #ratingText{
        display: none;
    }

    #rateItOuter .cust-modal-content.rotated .closer{
        left: 20px;
        right: auto;
    }

    #rateItOuter .cust-modal-content.rotated .rater-title,
    #rateItOuter .cust-modal-content.rotated .save-rate-expert,
    #rateItOuter .cust-modal-content.rotated textarea,
    #rateItOuter .cust-modal-content.rotated #ratingText{
        -webkit-transform: rotateY(-180deg);
        -moz-transform: rotateY(-180deg);
        -ms-transform: rotateY(-180deg);
        -o-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
    }

    #rateItOuter .cust-modal-content.rotated .save-rate-expert{
        float: left !important;
    }

    @media only screen and (max-width: 760px) {
        #rateItOuter .cust-modal-content{
            box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2) !important;
            padding: 22px 26px !important;
            padding-top: 8px !important;
            border-radius: 6px !important;
            width: calc(100vw - 72px) !important;
            height: auto !important;
            padding-bottom: 25px !important;
            margin: auto !important;
        }

        #rateItOuter .cust-modal-content.rotated #ratingText{
            bottom: 45px !important;
        }
    }
</style>
<div id="rateItOuter" class="cust-modal has-trans">
    <div class="cust-modal-content" style="position: relative;">
        @if(Auth::user())
            <button class="closer" onclick="closeRateIt()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="rateIt" onsubmit="addRateIt(event)">
                <h3 class="rater-title">
                    <span id="realTitle">
                        Your Rating
                    </span>
                    <span>
                        Add a comment
                    </span>
                </h3>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <input id="ratingInput" type="hidden" name="rating">
                {{csrf_field()}}

                <textarea style="font-size: 1.3em" name="comment" cols="30" rows="2" placeholder="Your comment"></textarea>

                <div class="" style="margin-bottom: 35px;">
                    <div class="rate-expert" style="min-height: 30px;"></div>
                </div>

                <span id="ratingText" style="font-size: 1.3em; color: #aaa; position: absolute; bottom: 32px; right: 25px">SOME TEXT</span>
                <button class="btn btn-primary save-rate-expert" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="submit">SUBMIT</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to rate</p>
        @endif
    </div>
</div>

<script>
	var rated_type, rate_id, rate_btn;

    function closeRateIt() {
        $("#rateItOuter .cust-modal-content").removeClass('rotated');
        $("#rateItOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#rateItTitle").val("");
    }

    function openRateIt(e, type, rated) {
	    rate_btn = e.target;

//	    rate_btn.classList.add("hidden");

	    if(type && rated){
		    rated_type = type.toLowerCase();
		    rate_id = rated;

		    $("#realTitle").text("Rate " + type);
	    }else
		    $("#realTitle").text("Your Rating");

        $("#rateItOuter").addClass("open");
        $("body").addClass("locked");
    }

    function addRateIt(e){
        if(e){
            e.preventDefault();
        }

	    var formdata = new FormData($("#rateIt")[0]);

	    if(!rated_type || !rated_type.length)
            ratingSet(formdata);
	    else {
		    formdata.append("rate_id", rate_id);
		    formdata.append("what", rated_type);

		    showLoading();
		    console.log("Tunaituma sas!");
		    $.ajax({
			    type:'POST',
			    url: "/rateIt",
			    data: formdata,
			    dataType:'json',
			    async:false,
			    processData: false,
			    contentType: false
		    })
		    .done(function(response){
		        console.log(response);
//                document.write(response.responseText);
			    if(response.success){
				    showToast("success", response.msg);
				    if(rate_btn.localName == "button"){
					    rate_btn.classList.add("hidden");
				    }else{
					    $(rate_btn).parents("button").addClass("hidden");
				    }
				    closeRateIt();
			    }else{
				    $('.save-rate-expert').removeAttr("disabled");
				    showToast("error", response.msg);

				    rate_btn.classList.remove("hidden");
			    }
		    })
		    .fail(function(response){
//			    document.write(response.responseText);
			    $('.save-rate-expert').removeAttr("disabled");
			    showToast("error", "Unknown Error occured");

			    rate_btn.classList.remove("hidden");
		    })
		    .always(function(){
			    hideLoading();
		    });
	    }
    }

    $(".rate-expert").rateYo({
        maxValue: 5,
        numStars: 5,
        fullStar: true,
        starWidth: "30px"
    }).on("rateyo.set", function (e, data) {
        var rating = data.rating;
        $("#rateItOuter .cust-modal-content #ratingInput").val(rating);
        $("#rateItOuter .cust-modal-content #ratingText").text("RATING : " + rating);
        $("#rateItOuter .cust-modal-content").addClass('rotated');
        $("#rateItOuter .cust-modal-content textarea").focus();
    });
</script>