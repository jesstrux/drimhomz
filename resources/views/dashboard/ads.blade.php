<style>
    .setup-field{
        display: -webkit-flex;
        display: -moz-flex;
        display: -ms-flex;
        display: -o-flex;
        display: flex;
        -ms-align-items: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .setup-field label{
        padding-left: 0;
        float: none;
    }

    .setup-field .form-control{
        float: none !important;
    }

    .ad-image{
        border: none;
        border-radius: 5px;
        box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.3);
        margin: 8px;
        background-color: #f3f3f3;
        height: 240px;
        width: 100%;
        overflow: hidden;
    }
</style>
<section class="short">
    <div class="section-header text-center">
        <h3>Advertisements</h3>
        <p>
            To create a new advertisement, click the button below.<br>
            {{--<button class="round-btn" style="padding: 5px 20px; min-width: 0">Add Advertisement</button>--}}
        </p>
    </div>
</section>

<section class="container-fluid" style="padding: 25px 30px;">
    <div style="width: 700px; background-color: #1b6d85; margin: 10px 0; padding: 20px; color : #fff">
        <h3 style="margin-bottom: 30px;">New Advertisement</h3>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success</strong>
                {{Session::get('success')}}
            </div>
        @endif

        <form id="info" role="form" method="POST" action="{{ url('/createAd') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="layout">
                <div style="width: 200px; margin-right: 60px; padding-bottom: 10px;">
                    <label fo="image" class="ad-image has-image" style="border: 1px dashed #777; position: relative; margin-bottom: 15px;">
                        <div class="layout center-center" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; background-color: transparent; pointer-events: none">
                            <h5 style="font-size: 1.4em; color: #999; font-weight: bold; text-align: center; line-height: 30px">Advertisement Image</h5>
                        </div>
                        <img id="previewAd" src="" width="100%">
                    </label>

                    <input id="image" type="file" onchange="showImage(this)" accept="images/*" name="image" required>
                </div>

                <div class="flex">
                    <div class="setup-field">
                        <label for="title" class="col-md-3 control-label">Title</label>

                        <div class="col-md-9">
                            <input id="title" type="text" class="form-control" name="title" required>
                        </div>
                    </div>

                    <div class="setup-field">
                        <label for="priority" class="col-md-3 control-label">Priority</label>

                        <div class="col-md-9">
                            <select id="priority" type="text" class="form-control" name="priority" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="setup-field" style="align-items: flex-start">
                        <label for="link" class="col-md-3 control-label">Link</label>

                        <div class="col-md-9">
                            <input rows="3" id="description" type="text" class="form-control" name="link" required/>
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <button class="btn btn-warning" style="font-size: 17px;width: 120px; padding: 6px 0; margin-right: 15px;">SAVE AD</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php
        $notnull = count($randomAds) > 0;
    ?>
    <div class="row">
        <div class="col col-md-12">
            <h3 style="margin-left: 8px;">All Ads</h3>
            @if($notnull)
                <div class="layout wrap">
                    @foreach($randomAds as $ad)
                        <div style="margin: 8px; background-color: #ddd; height: 240px; width: calc(20% - 16px); overflow: hidden;">
                            <img width="100%" src="{{$banner_url . $ad->image_url }}" alt="{{$banner_url . $ad->image_url}}">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-message">There are no featured ads.</div>
            @endif
        </div>
    </div>
</section>


<script>
    function showImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.querySelector('#previewAd').src =  e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>