@extends('layouts.app')

@section('content')

    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="" alt="" width="100%" height="210px" style="background-color: #eee; border: none; max-width: 260px; border-radius: 5px">
                <h2>{{$office->name}}</h2>
                <br>
                <div class="rateyo"></div>
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

                    <h3 style="margin-top: 40px;margin-bottom: 20px;">Location - ({{$office->user->town}})</h3>
                    @if(isset($office->user->town) && strlen($office->user->town) > 0)
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
    <script src="{{asset('js/jjquery.rateyo.min.js')}}"></script>

    <script>
        $("#my_input").geocomplete({
            map: "#my_map"
        });
        $("#my_input").trigger("geocode");

        $(".rateyo").rateYo();
    </script>
@endsection