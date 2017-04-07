@extends('layouts.app')

@section('content')

    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col-md-4 layout vertical">
                <?php $image_url = isset($office->image_url) && strlen($office->image_url) > 0 ? $office->image_url : 'def.png'?>
                <img src="{{$office_url . $image_url}}" alt="" width="100%" height="210px" style="background-color: #eee; border: none; max-width: 260px; border-radius: 5px">
                <h2 style="margin-bottom: 15px; font-size: 1.5em;">{{$office->name}}</h2>
                <div class="layout center">
                    <div style="color: #aaa; font-size: 2rem; background: #000;padding: 8px; padding-bottom: 10px;letter-spacing: 4px">
                        {{number_format($office->user->rating(), 1, '.', '')}}
                    </div>&nbsp;
                    <div class="layout vertical">
                        <div class="expert-rating" style="min-height: 20px"></div>&nbsp;
                        by {{$office->user->ratings()->count()}} people
                    </div>
                </div>

                @if(!Auth::guest() && Auth::user()->id != $office->user_id)
                    <button class="btn" style="background-color: #f1a00b; color: #f1eee9; align-self: flex-start; margin-top: 15px; margin-bottom: 20px;" onclick="openRateExpert()">
                        RATE EXPERT
                    </button>
                @else
                    <div style="margin-bottom: 25px;"></div>
                @endif
            </div>

            <div class="col-md-8">
                <div style="padding: 30px; background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,0.26); margin-bottom: 30px; border-radius: 4px">
                    <h3>About</h3>
                    <p>
                        @if(isset($office->user->description) && strlen($office->user->description) > 0)
                            $office->user->description
                        @else
                            No description provided.
                        @endif
                    </p>

                    <?php $town_available = isset($office->user->town) && strlen($office->user->town) > 0 ?>
                    <h3 style="margin-top: 40px;margin-bottom: 20px;">Location @if($town_available) ({{$office->user->town}}) @endif</h3>
                    @if($town_available)
                        <p>
                            <input type="hidden" id="my_input" value="{{$office->user->town}}">
                            <div id="my_map" style="background-color: #eee; height: 400px; width: 100%;"></div>
                        </p>
                    @else
                        <p>
                            No location provided.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="http://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBgc2zYiUzXGjZ277annFVhIXkrpXdOoXw"></script>
    <script src="{{asset('js/jquery.geocomplete.min.js')}}"></script>
    <script src="{{asset('js/jquery.rateyo.min.js')}}"></script>

    <script>
        $("#my_input").geocomplete({
            map: "#my_map"
        });
        $("#my_input").trigger("geocode");

        $(".expert-rating").rateYo({
            readOnly: true,
            maxValue: 5,
            numStars: 5,
            halfStar: true,
            starWidth: "20px",
            rating: <?php echo $office->user->rating() ?>
        });
    </script>

    @include('expert.rate_expert')
@endsection