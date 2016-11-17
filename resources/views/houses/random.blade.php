<style>
    .grid-sizer, .grid-item{
        background-color: green;
        width: 33.333%;
        margin: 0;
    }
    .grid-item{
    	height: 200px;
    }
    @media all and (max-width: 600px) {
    	.grid-item{
	    	width: 50%;
	    	height: 50vw;
	    }
    }
</style>
<div class="image-gri layout" style="max-width: 100%; flex-wrap: wrap">
    <!-- <div class="grid-sizer"></div> -->
    
    @for ($i = 1; $i < 7; $i++)
        <img src="{{asset('images/slideshow/slide'.$i.'.jpg')}}" class="grid-item" alt="">
    @endfor
</div>