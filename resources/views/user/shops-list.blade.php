@foreach($list as $fol)
    <a href="{{url('/shop/').'/'.$fol->id}}" class="house-card">
        <div class="image" style="background-color: #eee; border: 1px solid #eee">
            <img src="{{asset($shop_url . $fol->image_url)}}" alt="{{$fol->name}}'s dp">
        </div>
        <div class="content">
            <h3>{{$fol->name}}</h3>
        </div>
    </a>
@endforeach