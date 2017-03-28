<?php
if(!Auth::guest()){
    $user = Auth::user();
}
?>
<style>
    #newAd{
        /*background-color: rgba(0,0,0,0.1);*/
    }
    #newAd .cust-modal-content{
        position: relative;
        box-shadow: none;
        background-color: transparent;

        /*padding-top: 8px;border-radius: 6px;*/
    }

    #adContent{
        min-height: 240px;
        min-width: 350px;
        padding: 20px;
        padding-bottom: 30px;
        /*text-align: right;*/
        background-color: #fff;
    }

    @media only screen and (max-width: 760px) {
        #newAd{
            padding-top: 60px;
            height: 100vh;
            overflow-y: auto;
            background-image: none;
            background: #fff;
        }

        #newAd .cust-modal-content{
            height: 100vh;
            display: block !important;
            padding: 0 !important;
            width: 100vw;
            box-shadow: none;
            background: #fff;
        }

        #adContent{
            background: #fff;
            padding: 22px 26px;
            min-width: 0;
            width: 100vw;
            min-height: 0;
            text-align: left;
        }

        #adContent p{
            font-size: 1.3em;
        }

        #adContent #adImageContainer{
            margin-bottom: 25px;
        }
    }
</style>
<div id="newAd" href="https://google.com" class="cust-modal" style="text-decoration: none; color: inherit; font-family: inherit">
    <button class="closer --js-house-preview-closer" onclick="closeAd()">
        <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>

    <div class="hidden visible-xs cust-modal-toolbar" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeAd()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 id="adTitleMob" class="flex ad-title" style="font-size: 23px; margin: 0; margin-left: 8px;"></h5>

            <a class="btn ad-link" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                VIEW MORE
            </a>
        </div>
    </div>

    <div class="layout center-center cust-modal-content">
        <img id="adImage" src="" alt="" class="hidden-xs" style="min-width:330px;width: 330px !important; height: 460px; background-color: #ddd">
        <div id="adContent" clas="flex">
            <div id="adImageContainer" class="hidden visible-xs" style="width: 100%; height: 300px; overflow: hidden; text-align: center;">
                <img id="adImageMob" src="" alt="" style="background-color: #ddd;height:100%; min-width: 220px">
            </div>
            <h2 class="ad-title hidden-xs">The title</h2>
            <p class="ad-description">
                Sorry, there was no description provided
            </p>

            <a class="btn ad-link hidden-xs" style="align-self: flex-start">
                LEARN MORE
            </a>
        </div>
    </div>
</div>

<script>
    function closeAd() {
        $("#newAd").removeClass("open");
        $("body").removeClass("locked");
    }

    function openAd(ad) {
        var ad_prev = $("#newAd");
        ad_prev.find("img").attr("src", "");
        ad_prev.find('.ad-link').attr("href", ad.link);
        ad_prev.find("img").attr("src", ad_base_url + ad.image_url);
        ad_prev.find(".ad-title").text(ad.title);
        ad_prev.find(".ad-description").text(ad.description && ad.description.length ? ad.description : "Sorry, there was no description provided");
        ad_prev.addClass("open");

        $("body").addClass("locked");
    }
</script>