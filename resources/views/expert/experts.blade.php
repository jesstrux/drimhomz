<style>
    .big-outer{
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
        min-height: 110px;
        width: 150px;
    }

    .expert-info{
        padding: 0 15px;
        margin-left: 5px;
        width: 100%;
        box-shadow: none !important;
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
            min-height: 40px;
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
@if($products->count() < 1)
    <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">There are no experts available.</div>
@endif

@foreach($products as $product)
    {{--.'/'.$product->office->id--}}
    <a href="{{url('/user/'.$product->id)}}" class="big-outer" id="product_{{$product->id}}">
        <div>
            <?php
                $full_name = $product->fname . " " . $product->lname;
                $large_text = strlen($full_name) < 80 ? "large-text" : "";

                $articles_count = $product->articles->count();
                $articles_link = $articles_count > 0 ? url("/articlesByWriter/$product->id") : "";

                $answers_count = $product->answers->count();
                $answers_link = $answers_count > 0 ? url("/answersByWriter/$product->id") : "";
            ?>
            <div class="expert-wrapper layout">
                <div class="expert-image">
                    <img src="{{$user_url . $product->dp}}" width="100%" alt="" />
                </div>

                <div class="expert-info layout vertical" style="box-shadow: none !important">
                    <h3>
                        {{$product->full_name()}}
                    </h3>

                    <span style="display: block">
                        Expertise:
                        <span style="font-weight: bold;">
                            {{$product->role}}
                        </span>
                    </span>

                    <div class="layout center">
                        <span style="color: #000 !important; letter-spacing: 3px; margin-right: 5px;">{{number_format($product->rating(), 1, '.', '')}}</span>
                        <svg fill="#888" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <div class="expert-activity hidden">
                        <a hre="{{$articles_link}}">
                            {{$articles_count}} Articles
                        </a>
                        &nbsp; | &nbsp;
                        <a hre="{{$answers_link}}">
                            {{$answers_count}} Answers
                        </a>  
                    </div>
                </div>
            </div>
        </div><!--end .col, .card -->
    </a><!--end .row -->
    @if($loop->iteration != $products->count())
        <hr style="border-color: #e0e0e0">
    @else
        <br>
    @endif
@endforeach