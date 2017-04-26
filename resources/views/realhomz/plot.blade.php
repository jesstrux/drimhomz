<div class="expert-image" style="background-image: url({{$plot_url . $real->image()}})"></div>

<div class="expert-info layout vertical">
    <h3>
        {{$real->name}}
    </h3>
    <p><span style="color: #ffa500; font-weight: bold;">PRICE:</span> <strong>Tshs. {{number_format( $real->price, 0 )}}</strong></p>
    <span class="real-description hidden-xs">
        {{$real->description}}
    </span>
     <span class="real-description hidden-xs">
       <b>Town:</b> {{$real->town}}
    </span>
    <p><span style="color: #ffa500; font-weight: bold;">By:</span> <strong> {{$real->fname}} {{$real->lname}} | {{$real->phone}}</strong></p>
</div>