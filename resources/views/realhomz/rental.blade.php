<div class="expert-image" style="background-image: url({{$rental_url . $real->image()}})"></div>

<div class="expert-info layout vertical">
    <h3>
        {{$real->name}}
    </h3>
    <p><span style="color: #ffa500; font-weight: bold;">PRICE:</span> <strong>Tshs. {{number_format( $real->price / 100, 0 )}}</strong></p>
    <span class="real-description hidden-xs">
        {{$real->description}}
    </span>
</div>