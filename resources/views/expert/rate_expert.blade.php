<style>
    #rateExpertOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }

    #rateExpertOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
        width: 300px;
        overflow: hidden;
        overflow-y: auto;
        padding-bottom: 15px;
    }

    #rateExpertOuter .cust-modal-content.rotated{
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

    #rateExpertOuter .cust-modal-content.rotated .rater-title span:first-child,
    #rateExpertOuter .cust-modal-content.rotated .rate-expert{
        display: none;
    }

    #rateExpertOuter .cust-modal-content:not(.rotated ) .rater-title span:last-child,
    #rateExpertOuter .cust-modal-content:not(.rotated ) textarea,
    #rateExpertOuter .cust-modal-content:not(.rotated ) .save-rate-expert.save-rate-expert,
    #rateExpertOuter .cust-modal-content:not(.rotated ) #ratingText{
        display: none;
    }

    #rateExpertOuter .cust-modal-content.rotated .closer{
        left: 20px;
        right: auto;
    }

    #rateExpertOuter .cust-modal-content.rotated .rater-title,
    #rateExpertOuter .cust-modal-content.rotated .save-rate-expert,
    #rateExpertOuter .cust-modal-content.rotated textarea,
    #rateExpertOuter .cust-modal-content.rotated #ratingText{
        -webkit-transform: rotateY(-180deg);
        -moz-transform: rotateY(-180deg);
        -ms-transform: rotateY(-180deg);
        -o-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
    }

    #rateExpertOuter .cust-modal-content.rotated .save-rate-expert{
        float: left !important;
    }

    @media only screen and (max-width: 760px) {
        #rateExpertOuter .cust-modal-content{
            box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2) !important;
            padding: 22px 26px !important;
            padding-top: 8px !important;
            border-radius: 6px !important;
            width: calc(100vw - 72px) !important;
            height: auto !important;
            padding-bottom: 25px !important;
            margin: auto !important;
        }

        #rateExpertOuter .cust-modal-content.rotated #ratingText{
            bottom: 45px !important;
        }
    }
</style>
<div id="rateExpertOuter" class="cust-modal has-trans">
    <div class="cust-modal-content" style="position: relative;">
        @if(Auth::user())
            <button class="closer" onclick="closeRateExpert()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="rateExpert" method="POST" action="/rateExpert" onsubmit="addRateExpert(event)">
                <h3 class="rater-title">
                    <span>
                        Rate Expert
                    </span>
                    <span>
                        Add a comment
                    </span>
                </h3>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <input type="hidden" name="expert_id" value="{{$expert->id}}">
                <input id="ratingInput" type="hidden" name="rating">
                {{csrf_field()}}

                <textarea style="font-size: 1.3em" name="comment" cols="30" rows="2" placeholder="Your comment"></textarea>

                <div class="" style="margin-bottom: 35px;">
                    <div class="rate-expert" style="min-height: 30px;"></div>
                </div>

                <span id="ratingText" style="font-size: 1.3em; color: #aaa; position: absolute; bottom: 32px; right: 25px">SOME TEXT</span>
                <button class="btn btn-primary save-rate-expert" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="button" onclick="addRateExpert()">SUBMIT</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to rate expert</p>
        @endif
    </div>
</div>

<script>
    function closeRateExpert() {
        $("#rateExpertOuter .cust-modal-content").removeClass('rotated');
        $("#rateExpertOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#rateExpertTitle").val("");
    }

    function openRateExpert() {
        $("#rateExpertOuter").addClass("open");
        $("body").addClass("locked");
    }

    function addRateExpert(e){
        if(e){
            e.preventDefault();
        }

        showLoading();
        var formdata = new FormData($("#rateExpert")[0]);

        $.ajax({
            type:'POST',
            url: "/rateExpert",
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            if(response.success){
                closeRateExpert();
                showToast("success", response.msg);
            }else{
                $('.save-rate-expert').removeAttr("disabled");
                showToast("success", response.msg);
            }
        })
        .fail(function(response){
            $('.save-rate-expert').removeAttr("disabled");
            showToast("error", "Unknown Error occured");
        })
        .always(function(){
            hideLoading();
        });
    }

    $(".rate-expert").rateYo({
        maxValue: 5,
        numStars: 5,
        fullStar: true,
        starWidth: "30px"
    }).on("rateyo.set", function (e, data) {
        var rating = data.rating;
        console.log(rating);

        $("#rateExpertOuter .cust-modal-content #ratingInput").val(rating);
        $("#rateExpertOuter .cust-modal-content #ratingText").text("RATING : " + rating);
        $("#rateExpertOuter .cust-modal-content").addClass('rotated');
        $("#rateExpertOuter .cust-modal-content textarea").focus();
    });
</script>