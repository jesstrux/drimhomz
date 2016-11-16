<style>
    .grid-sizer, .grid-item{
        background-color: green;
        width: 33.333%;
        margin: 0;
    }
</style>
<div class="image-grid">
    <div class="grid-sizer"></div>
    
    @for ($i = 1; $i < 7; $i++)
        <img src="{{asset('images/slideshow/slide'.$i.'.jpg')}}" class="grid-item" alt="">
    @endfor
</div>