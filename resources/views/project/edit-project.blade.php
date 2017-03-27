@extends('layouts.app')

@section('content')
@include('layouts.header')

<style>
    #pnewPofilePage{
        /*margin-top: 40px;*/
    }

    #pnewPofilePage #outer{
        margin-top: 40px;
        max-width: 700px;
    }

    #pnewPofilePage #wrapper{
        box-shadow: 0 0 5px 1px rgba(0,0,0,0.15);
        border-radius: 5px;
    }

    #pnewPofilePage #dpEditor, #pnewPofilePage #editorForm{
        padding: 35px 30px;
        /*background-color: purple;*/
    }

    #pnewPofilePage #editorForm h3{
        margin-top: 0;
        color: #000;
    }

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

    #savebtnWrapper{
        margin-top: 30px;
    }

    #savebtnWrapper .btn{
        float: right;
    }

    @media all and (max-width: 780px) {
        #info{
            padding-top: 10px;
        }
        #pnewPofilePage #outer{
            margin-top: 10px;
        }
        #pnewPofilePage #wrapper{
            box-shadow: none;
        }

        #pnewPofilePage #dpEditor{
            display: none;
        }

        #pnewPofilePage #editorForm{
            padding: 10px;
            width: 100%;
        }

        .setup-field{
            width: 100%;
            -webkit-flex-direction: column;
            -moz-flex-direction: column;
            -ms-flex-direction: column;
            -o-flex-direction: column;
            flex-direction: column;
            -ms-align-items: flex-start;
            align-items: flex-start;
        }

        .setup-field label{

        }

        .setup-field .col-md-8{
            padding: 0;
            margin-top: 5px;
            width: 100%;
        }

        .setup-field .form-control{
            width: 100% !important;
        }
    }

    @media all and (min-width: 781px) {
        #editorForm{
            width: 100%
        }
        #info{
            padding-top: 30px;
        }
        #savebtnWrapper{
            margin-top: 30px;
            margin-right: 15px;
        }
    }
</style>

<div id="pnewPofilePage">
    <div id="outer" class="container">
        <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
            <div id="editorForm">
                <h3>Edit project</h3>

                @if($errors->any())
                    <div class="alert alert-error alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong>{{$errors->first()}}
                    </div>
                @endif

                @if (\Session::has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success!</strong> {!! \Session::get('success') !!}
                    </div>
                @endif

                <div id="infoSavedAlert" class="alert alert-success alert-dismissible collapse" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> Changes saved.
                </div>

                <form id="info" role="form" method="POST" action="{{ url('/editProject') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $project->id }}">
                    <div class="setup-field">
                        <label for="title" class="col-md-4 control-label">Title</label>

                        <div class="col-md-8">
                            <input id="title" type="text" class="form-control" name="title" value="{{ $project->title }}" required autofocus>
                        </div>
                    </div>

                    <div class="setup-field">
                        <label for="location" class="col-md-4 control-label">Location</label>

                        <div class="col-md-8">
                            <input id="location" placeholder="Location" type="text" class="form-control" name="location" value="{{$project->location}}" required>
                        </div>
                    </div>

                    <div class="setup-field">
                        <label for="coords" class="col-md-4 control-label">Coords</label>

                        <div class="col-md-8">
                            <input id="coords" readonly placeholder="coords" type="text" class="form-control" name="coords" value="{{$project->coords}}" required>
                        </div>
                    </div>

                    <div class="setup-field">
                        <label for="timeStart" class="col-md-4 control-label">Start time</label>

                        <div class="col-md-8">
                            <input id="timeStart" placeholder="Start time" type="date" class="form-control" value="{{date('Y-m-d',strtotime($project->time_start))}}" required>
                        </div>
                    </div>

                    <div class="setup-field">
                        <label for="timeFin" class="col-md-4 control-label">Finish time</label>

                        <div class="col-md-8">
                            <input id="timeFin" placeholder="Start time" type="date" class="form-control" name="time_finish" value="{{date('Y-m-d',strtotime($project->time_finish))}}" required>
                        </div>
                    </div>

                    <div class="setup-field">
                        <label for="budget" class="col-md-4 control-label">Budget</label>

                        <div class="col-md-8">
                            <input id="budget" placeholder="budget" type="number" class="form-control" name="budget" value="{{$project->budget}}" required>
                        </div>
                    </div>

                    <div id="savebtnWrapper" class="form-group">
                        <button type="submit" onclic="saveBasicInfo()" class="btn btn-primary">
                            &emsp;Save&emsp;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="http://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBgc2zYiUzXGjZ277annFVhIXkrpXdOoXw"></script>
<script src="{{asset('js/jquery.geocomplete.min.js')}}"></script>

<script>
    // const API_KEY = "AIzaSyAQcqitQMDb4pWTudvPoZt6golxzFXrvmI";
    var tempImage;
    var image = $("#curDp");

    function saveBasicInfo(){
//        var date = new Date($("#dob").val());
//        $("#realDob").val($("#dob").val());
//        console.log($("#dob").val());

        persistChanges("editProject", "info");
    }

    function goHome(){
        window.location.href = "/";
    }

    function persistChanges(url, form){
        $.ajax({
                type:'POST',
                url: url,
                data:new FormData($("#"+form)[0]),
                dataType:'json',
                async:false,
                processData: false,
                contentType: false
            })
            .done(function(response){
                console.log("Response!, ", response);
            })
            .fail(function(response){
                console.log("Response!, ", response);

                if(response.responseText == "success"){
                    basicInfoSaved();
                }
                else{
                    console.log("Error occured!", response);
                }
            })
            .always(function(){
                console.log("Action done");
            });
    }

    function basicInfoSaved(){
        $("#infoSavedAlert").show();
        setTimeout(function(){
            $("#infoSavedAlert").hide();
        }, 2000);
    }

    function basicInfoSavedMob(){
        $("#info").fadeOut('slow', function() {
            $("#dp").fadeIn("fast");
        });
    }

    function dpSaved(){
        setTimeout(function(){
            image.attr("src", tempImage);
            $("#dp").removeClass('loading-dp');
            $("#dpSavedAlert").show();

            setTimeout(function(){
                $("#dpSavedAlert").hide();
            }, 2000);
        }, 200);
    }

    function dpSavedMob(){
        $("#form").fadeOut('slow', function() {
            $("#profile").fadeIn("fast");

            $("#titleText").hide();
        });
    }

    //   	window.onload = function() {
    //   		var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=178.294721, -2.358263&amp;key=AIzaSyAQcqitQMDb4pWTudvPoZt6golxzFXrvmI";

    // 	$.get(url, function (response) {
    // 	    console.log(JSON.stringify(response, null, 4));
    // 	});
    // };

    $("#location").geocomplete()
        .bind("geocode:result", function(event, result){
            var loc = result.geometry.location;
            $("#coords").val(loc.lng() + ", " + loc.lat());
        })
        .bind("geocode:error", function(event, status){
            console.log("ERROR: " + status);
        })
        .bind("geocode:multiple", function(event, results){
            console.log("Multiple: " + results.length + " results found");
        });

    // $("#find").click(function(){
    //   $("#coords").trigger("geocode");
    // });
</script>
@endsection