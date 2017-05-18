<style>
    #shopTabs > a{
        font-size: 1.3em;
        color: #555;
        text-decoration: none;
    }

    #shopTabs > a.active{
        /*color: #333;*/
        font-weight: bold;
        pointer-events: none;
    }

    #shopTabs > a:not(:last-child):after{
        content: "/";
        color: #555;
        margin: 0 10px;
        font-weight: normal;
    }

    #shopSections > div{
        padding: 12px 0;
        /*max-width: calc(100% - 24px);*/
    }

    #shopSections > div:not(.current){
        display: none;
    }

    #shopSections > div:not(.showing){
        opacity: 0;
        pointer-events: none;

        -webkit-transition: opacity 0.15s ease-in;
        -moz-transition: opacity 0.15s ease-in;
        -ms-transition: opacity 0.15s ease-in;
        -o-transition: opacity 0.15s ease-in;
        transition: opacity 0.15s ease-in;
    }

    #shopSections div.showing{
        -webkit-transition: opacity 0.35s ease-out 0.25s;
        -moz-transition: opacity 0.35s ease-out 0.25s;
        -ms-transition: opacity 0.35s ease-out 0.25s;
        -o-transition: opacity 0.35s ease-out 0.25s;
        transition: opacity 0.35s ease-out 0.25s;
    }

    .section{
        list-style: none;
        display: block;
        display: -webkit-flex;
        display: -moz-flex;
        display: -ms-flex;
        display: -o-flex;
        display: flex;
        -webkit-flex-wrap: wrap;
        -moz-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        -o-flex-wrap: wrap;
        flex-wrap: wrap;
        position: relative;
        padding: 0;
        margin: 0;
        min-width: 100%;
        width: 100%;
        max-width: 100%;
    }

    .section .house-card, .section .new-button{
        width: calc(50% - 10px);
        min-width: calc(50% - 10px);
        max-width: calc(50% - 10px);
        display: inline-block;
        margin: 0 5px;
        margin-bottom: 15px;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0 0 1px rgba(0,0,0,0.35);
        padding: 8px;
    }

    .section .house-card .content h3{
        font-size: 1.2em;
        margin-bottom: 5px;
        margin-top: 15px;
        white-space: nowrap;
        overflow: hidden;
        -ms-text-overflow: ellipsis;
        text-overflow: ellipsis;
    }

    .section .house-card .content .social-stuff{
        font-size: 0.9em;
        display: inline-block;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        -ms-text-overflow: ellipsis;
        text-overflow: ellipsis;
    }

    .section .house-card .content .social-stuff span{
        font-size: 0.8em;
    }

    .section .house-card .image, .new-button .image{
        height: 150px; overflow: hidden;
        border-radius: 5px;
        background-color: #f4f4f4;
    }

    .section .house-card .image img,
    .section .house-card .image .userview-image{
        height: 100%;
        min-width: 100%;
    }

    @media all and (min-width: 900px) {
        .section .new-button, .section .house-card{
            width: calc(33.333% - 10px);
            min-width: calc(33.3333% - 10px);
            max-width: calc(33.333% - 10px);
            padding: 16px;
        }

        .section .house-card .image, .new-button .image{
            height: 200px; overflow: hidden;
            border-radius: 5px;
            background-color: #f4f4f4;
        }
    }

    .house-card p{
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        -ms-text-overflow: ellipsis;
        text-overflow: ellipsis;
    }
</style>
<div id="shopTabs">
    <a class="active" href="javascript:void(0);" target="#shopAbout">About</a>
    <a href="javascript:void(0);" target="#shopProducts">Products</a>
    <a href="javascript:void(0);" target="#shopRatings">Ratings</a>
</div>

@if($errors->any())
    <div class="alert alert-error alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong>{{$errors->first()}}
    </div>
@endif

@if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success!</strong> {!! \Session::get('success') !!}
    </div>
@endif

<div id="shopSections" class="layout">
    <div id="shopAbout" class="section current showing">@include('shop.about')</div>
    <div id="shopProducts" class="section">@include('shop.products')</div>
    <div id="shopRatings" class="section">@include('shop.ratings')</div>
</div>

<script>
    $("#shopTabs a").click(function(){
        $("#shopTabs a").not($(this)).removeClass('active');
        $(this).addClass('active');

        var ol_cur = $("#shopSections .section").not($(this).attr('target'));
        ol_cur.removeClass("showing");
        setTimeout(function(){
            ol_cur.removeClass("current");
        }, 10);

        var new_cur = $($(this).attr('target'));
        new_cur.addClass("current");
        setTimeout(function(){
            new_cur.addClass("showing");
        }, 200);
    });
</script>