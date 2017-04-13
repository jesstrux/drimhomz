<style>
    #becomeSellerOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }

    #becomeSellerOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
        width: 300px;
        overflow: hidden;
        overflow-y: auto;
        padding-bottom: 15px;
        height: 230px;
    }

    @media only screen and (max-width: 760px) {
        #becomeSellerOuter .cust-modal-content{
            box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2) !important;
            padding: 22px 26px !important;
            padding-top: 8px !important;
            border-radius: 6px !important;
            width: calc(100vw - 72px) !important;
            height: auto !important;
            padding-bottom: 25px !important;
            margin: auto !important;
        }

        #becomeSellerOuter .cust-modal-content.rotated #ratingText{
            bottom: 45px !important;
        }
    }
</style>
<div id="becomeSellerOuter" class="cust-modal has-trans">
    <div class="cust-modal-content" style="position: relative;">
        @if(Auth::user())
            <button class="closer" onclick="closeBecomeSeller()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <h3>Become A Seller</h3>
            <p style="margin-bottom: 20px;">To become a seller you have to create at least one shop</p>
            <button class="btn" onclick="closeBecomeSeller()">
                CANCEL
            </button>&nbsp;
            <button class="btn btn-primary" onclick="createShop()">CREATE SHOP</button>
            <br>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to rate expert</p>
        @endif
    </div>
</div>

<script>
    function createShop(){
        closeBecomeSeller();
        openNewShop();
    }
    function closeBecomeSeller() {
        $("#becomeSellerOuter .cust-modal-content").removeClass('rotated');
        $("#becomeSellerOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#becomeSellerTitle").val("");
    }

    function openBecomeSeller() {
        $("#becomeSellerOuter").addClass("open");
        $("body").addClass("locked");
    }
</script>