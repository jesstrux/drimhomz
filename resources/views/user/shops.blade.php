@if($myProfile)
    <a id="createShopBtn" href="javascript:void(0);" class="new-button" onclick="openNewShop()">
        <div id="createHouse" class="image layout center-center" style="background: #eee; height: 200px">
            <svg fill="#777" height="120" viewBox="0 0 24 24" width="120" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
            </svg>
        </div>
        <div style="margin-to: 5px;">
            <h3 style="font-size: 1.3em; margin: 0; padding: 12px 0;text-align: center;height: 40px; line-height: 30px">New Shop</h3>
        </div>
    </a>
@else
    @if(is_null($shops))
        @if(!$myProfile)
            <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
                {{$user->fname}} has no shops yet.
            </div>
        @else
            <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
                You have no shops.
            </div>
        @endif
    @endif
@endif

@if($shops_count > 0)
    @foreach($shops as $fol)
        <a href="{{url('/shops/').'/'.$fol->id}}" class="house-card">
            <div class="image" style="background-color: #eee">
                <img src="{{asset($shop_url . $fol->image_url)}}" alt="{{$fol->name}}'s dp">
            </div>
            <div class="content">
                <h3>{{$fol->name}}</h3>
            </div>
        </a>
    @endforeach
@endif

@include('shop.new-shop')

<script>
    function shopCreationSuccess(project){
        showToast("success", "Project created!");

        var proj_html = `<a href="/shop/`+project.id+`" class="house-card">
                <div class="image" style="pointer-events: auto;">
                <img src="`+ shop_base_url + `/def.png"/>
    </div>
        <div class="content">
                <h3 style="line-height: 30px;margin: 0; margin-top: 4px;">`+project.name+`</h3>
        </div>
        </a>`;

        var new_project = $(proj_html);
        $("#createShopBtn").after(new_project);
    }

    function projectCreationError(msg){
        var message = msg && msg.length ? msg : "Couldn't create shop!";
        showToast("error", message);
    }
</script>