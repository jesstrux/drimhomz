<div class="dh-card" style="isplay: inline-block; max-width: 700px; transform: none; opacity: 1; padding: 30px; margin: 45px auto;">
    <div class="content">
        <h3 id="previewTitle">{{$product->name}}</h3>
        <p id="previewCaption">Found at
            <a href="{{url('shop/'.$product->shop->id)}}">{{$product->shop->name}}</a>
        </p>
        
        <br>
        <div id="previewImageHolder" class="image">
            <img width="100%" id="previewImage" src="{{asset($res_url . '/products/'. $product->image_url)}}" alt="">
        </div>

        <br>
        <div class="layout">
            <div class="item single-line flex">
                <div class="avatar">
                    <img id="previewUserdp" src="{{asset($user_url . $product->owner()->dp)}}" alt="">
                </div>

                <div class="item-text">
                    <div class="title">
                        <a id="previewUsername">
                            {{$product->owner()->fname . " " . $product->owner()->lname}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>