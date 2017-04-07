<style>
    .big-outer{
        display: block;
        padding: 0 20px;
        margin-bottom: 10px;
        margin-top: 0;
    }
    .large-text{
        font-size: 2.5em !important;
        line-height: 1.5em !important;
    }

    .expert-wrapper{
        /*background-color: #00b3ee;*/
    }

    .expert-image{
        background-color: #ddd;
        height: 150px;
        width: 150px;
    }

    .expert-info{
        padding: 0 15px;
        margin-left: 5px;
        width: 100%;
    }

    .expert-info h3{
        color: #333;
        font-size: 2.1rem;
        margin: 0; margin-bottom: 10px;
    }

    .expert-activity{
        font-size: 1em;
        /*font-weight: bold;*/
        margin: 0;
    }

    @media only screen and (max-width: 760px) {
        .expert-image{
            height: 70px;
            width: 70px;
        }

        .expert-info h3{
            margin: 0; margin-bottom: 4px;
        }

        .expert-activity{
            margin-top: -5px;
        }
    }
    a{
        color: inherit !important;
        font-family: inherit;
    }
    a.card{
        text-decoration: none !important;
    }
</style>
@foreach($list as $real)
    <a href="{{url('realhomz/home/').'/'.$real->id}}" class="big-outer" id="real_{{$real->id}}">
        <div>
            <div class="expert-wrapper layout">
                @include('realhomz.home')
            </div>
        </div>
    </a>
    <br><br>
    {{--@if($loop->iteration != $list->count())--}}
        {{--<hr style="border-color: #e0e0e0">--}}
    {{--@else--}}
        {{--<br>--}}
    {{--@endif--}}
@endforeach