<style>
    .large-text{
        font-size: 2.5em !important;
        line-height: 1.5em !important;
    }
    .product-image{
        background-color: #ddd;
        height: 150px;
        width: 150px;
    }
    a{
        color: inherit !important;
        font-family: inherit;
    }
    a.card{
        text-decoration: none !important;
    }
</style>
@foreach($products as $product)
    <a href="{{url('/office/').'/'.$product->office->id}}" class="card no-pad" id="product_{{$product->id}}" style="margin-bottom: 10px; margin-top: 10px;">
        <div>
            <?php
                $full_name = $product->fname . " " . $product->lname;
                $large_text = strlen($full_name) < 80 ? "large-text" : "";

                $articles_count = $product->articles->count();
                $articles_link = $articles_count > 0 ? url("/articlesByWriter/$product->id") : "";

                $answers_count = $product->answers->count();
                $answers_link = $answers_count > 0 ? url("/answersByWriter/$product->id") : "";
            ?>
            <div class="layout">
                <div class="product-image">
                    <img src="{{$user_url . $product->dp}}" width="150px" height="150px" alt="" />
                </div>

                <div class="layout vertical" style="padding: 0 15px; margin-left: 5px; width: 100%;">
                    <h3 style="margin: 0; margin-bottom: 10px;">
                        {{$product->full_name()}}
                    </h3>

                    <em>
                        Expertise:
                        <span style="font-size: 1.4em; font-weight: bold;">
                            {{$product->role}}
                        </span>
                    </em>

                    <div style="font-size: 1em; font-weight: bold;margin: 0;">
                        <a hre="{{$articles_link}}">
                            {{$articles_count}} Articles
                        </a>
                        &nbsp;
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