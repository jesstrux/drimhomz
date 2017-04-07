<div class="expert-image" style="width: 150px; height: auto; position: relative; background-color: transparent">
    <img src="{{$home_url . $real->image()}}" style="background-color: #ddd;width:100%" alt="" />
</div>

<div class="expert-info layout vertical">
    <h3>
        {{$real->name}}
    </h3>
    <p>PRICE: <strong>Tshs. {{number_format( $real->price / 100, 0 )}}</strong></p>
    <span>
        {{$real->description}}
    </span>
</div>