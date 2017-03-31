<style>
    #fab-wrapper{
        position: fixed;
        top: 0; left: 0;
        right: 0;bottom: 0;
        z-index: 999;
        background-color: transparent;
        pointer-events: none;
    }

    .scrim{
        position: fixed;
        top: 0; left: 0;
        right: 0;bottom: 0;
        background-color: rgba(0,0,0,0.4);
    }

    .a-fab{
        outline: none !important;
        width: 40px;
        height: 40px;
        padding: 3px;
        border-radius: 50%;
        border: none;
        box-shadow: 0 0 8px 1px rgba(0,0,0,0.3);
        background-color: #f8f8f8;
        margin: 4px 0;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        align-items: center;
        justify-content: center;

        -webkit-transition: all 0.25s ease-out;
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        transition: all 0.25s ease-out;
    }

    .a-fab.sm{
        -webkit-transform: translateY(90%);
        -moz-transform: translateY(90%);
        -ms-transform: translateY(90%);
        -o-transform: translateY(90%);
        transform: translateY(90%);
    }

    .scrim, .a-fab{
        opacity: 0;
        pointer-events: none;
    }

    #fab-wrapper.open .a-fab.sm{
        -webkit-transform: none;
        -moz-transform: none;
        -ms-transform: none;
        -o-transform: none;
        transform: none;
    }

    #fab-wrapper.open,
    #fab-wrapper.open .a-fab.sm,
    #fab-wrapper.open .scrim{
        opacity: 1;
        pointer-events: auto;
    }

    .a-fab.lg{
        width: 56px;
        height: 56px;
        font-size: 23px;
        opacity: 1;
        pointer-events: auto;
        background-color: #ffa500;
        color: #f5f5f5;
    }

    #fab-wrapper.open .a-fab.lg{
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    #fab-wrapper .a-fab.lg:focus,
    #fab-wrapper .a-fab.lg:active{
        box-shadow: 0 0 20px 3px rgba(0,0,0,0.2);
    }
</style>
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
    <div id="fab-wrapper">
        <div class="scrim" onclick="closeFabs()">

        </div>
        <div class="layout vertical center" style="position: fixed; right: 20px; bottom: 20px;">
            <button class="a-fab sm" onclick="openNewHouseClick()">
                <i class="fa fa-home"></i>
            </button>
            <button class="a-fab sm" onclick="openNewProjectClick()">
                <i class="fa fa-briefcase"></i>
            </button>
            <button class="a-fab lg" onclick="toggleFabs()">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
@endif

<div class="image-grid">
        <ul id="container">
            
        </ul>

        <!-- <div class="empty-message">There are no featured houses.</div> -->
        <div style="position: relative; height: 50px; margin-bottom: 30px;">
            <div id="loaderMessage" class="empty-message api-message">Loading....</div>
            <div id="noMoreMessage" class="empty-message no-more-message api-message">No more dreams</div>
        </div>
</div>

<script src="{{asset('js/wookmark.min.js')}}"></script>
<script src="{{asset('js/imagesLoaded.min.js')}}"></script>
<script src="{{asset('js/houses-loader.js')}}"></script>

<script>
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