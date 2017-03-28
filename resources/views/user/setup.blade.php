@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <style>
    	#pnewPofilePage{
    		/*margin-top: 40px;*/
    	}

    	#pnewPofilePage #outer{
    		margin-top: 40px;
    		max-width: 900px;
    	}

    	#pnewPofilePage #wrapper{
    		box-shadow: 0 0 2px rgba(0,0,0,0.35);
    	}

    	#pnewPofilePage #dpEditor, #pnewPofilePage #editorForm{
    		padding: 35px 30px;
    		/*background-color: purple;*/
    	}

    	#pnewPofilePage #dpEditor{
    		border-right: 1px solid #eee;
    	}

    	#dp{
    		width: 120px;
    		height: 120px;
    		border-radius: 50%;
    		overflow: hidden;
    		margin-bottom: 15px;
    		position: relative;
    	}

    	#dp > img{
    		width: 100%;
    		cursor: pointer;
    	}

    	#dp #loadingDp{
    		position: absolute; 
    		height: 100%; width: 100%; 
    		background-color: rgba(255,255,255,0.8); 
    		z-index: 9;
    		opacity: 0;
    		pointer-events: none;
    	}

    	#dp.loading-dp #loadingDp{
    		opacity: 1;
    		pointer-events: auto;
    	}

    	#pnewPofilePage #editorForm{
    		padding-left: 60px;
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
    			width: 70%
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
		    	<div id="dpEditor" class="flex">
					@if (session('verification_status'))

						<div id="phoneVerifiedAlert" class="alert alert-success alert-dismissible collapse" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							{{session('verification_status')}}
						</div>
					@endif
					<form id="dpForm" enctype="multipart/form-data" role="form" method="POST" action="{{ url('save-dp') }}" class="layout vertical center">
	                	{{ csrf_field() }}

						<div id="dp">
							<?php 
								$dp = "images/uploads/user_dps/";
								$dp = isset($user->dp) ? $user->dp : 'drimhomzDefaultDp.png' ;

							?>

							<div id="loadingDp" class="layout center-center">
								<img src="{{asset('images/loading.gif')}}" alt="">
							</div>

							<img src='{{asset("storage/uploads/user_dps/$user->dp")}}' id="curDp" alt="">
						</div>

						<h3 style="margin-top: 0; margin-bottom: 15px;">Profile picture</h3>
						<input type="file" id="filePicker" name="dp" class="hidden" onchange="fileChosen()">

						<div class="layout">
							<label for="filePicker" class="btn btn-default">
	                            Change picture
	                        </label>
	                        <!-- &emsp;
	                        <button type="button" class="dp-uploader btn btn-dark" disabled onclick="saveDp()">
	                            &nbsp;Upload&nbsp;
	                        </button> -->
						</div>
					</form>

					<br>
					<div id="dpSavedAlert" class="alert alert-success alert-dismissible collapse" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Picture saved.
					</div>

		    	</div>
		    	<div id="editorForm">
		    		<h3>Edit your profile</h3>

		    		<div id="infoSavedAlert" class="alert alert-success alert-dismissible collapse" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Success!</strong> Changes saved.
					</div>
		    		
		    		<form id="info" role="form" method="POST" action="{{ url('setup-account-post') }}">
	                    {{ csrf_field() }}

	                    <div class="setup-field form-group{{ $errors->has('fname') ? ' has-error' : '' }}">
                            <label for="fname" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-8">
                                <input id="fname" type="text" class="form-control" name="fname" value="{{ $user->fname }}" required autofocus>

                                @if ($errors->has('fname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="setup-field form-group{{ $errors->has('lname') ? ' has-error' : '' }}">
                            <label for="lname" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-8">
                                <input id="lname" type="text" class="form-control" name="lname" value="{{ $user->lname }}" required>

                                @if ($errors->has('lname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="setup-field form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-8">
                                <input id="phone" type="tel" class="form-control" readonly name="phone" value="{{ $user->phone }}" required>
                                <span id="valid-msg" class="hide">✓ Valid</span>
                                <span id="error-msg" class="hide">Invalid number</span>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

	                    <div class="setup-field form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
		                    <label for="gender" class="col-md-4 control-label">Gender</label>

		                    <div class="col-md-8">
		                        <select id="gender" class="form-control" name="gender" required>
		                        	<option value="">Choose an option</option>

		                        	<?php 
		                        		$genders = ['Male', 'Female'];

		                        		foreach ($genders as $gender) {
		                        			$selected = $user->gender == $gender ? "selected" : "";

		                        			echo "<option value='$gender' $selected>$gender</option>";
		                        		};
		                        	?>
		                        </select>

		                        @if ($errors->has('gender'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('gender') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>

		                <div class="setup-field form-group{{ $errors->has('town') ? ' has-error' : '' }}">
		                    <label for="town" class="col-md-4 control-label">Town</label>

		                    <div class="col-md-8">
		                        <input id="town" placeholder="Town" type="text" class="form-control" name="town" value="{{$user->town}}" required>

		                        @if ($errors->has('town'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('town') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>

		                <div class="setup-field form-group{{ $errors->has('location') ? ' has-error' : '' }}">
		                    <label for="location" class="col-md-4 control-label">location</label>

		                    <div class="col-md-8">
		                        <input id="location" readonly placeholder="location" type="text" class="form-control" name="location" value="{{$user->location_str()}}" required>

		                        @if ($errors->has('location'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('location') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>

		                <div class="setup-field form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
		                    <label for="gender" class="col-md-4 control-label">Date of birth</label>

		                    <div class="col-md-8">
		                        <input id="dob" type="date" class="form-control" value="{{date('Y-m-d',strtotime($user->dob))}}" required>
		                        
		                        <input id="realDob" type="hidden" name="dob" value="{{date('Y-m-d',strtotime($user->dob))}}">

		                        @if ($errors->has('dob'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('dob') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>
                        <div id="savebtnWrapper" class="form-group">
                            <button type="button" onclick="saveBasicInfo()" class="btn btn-primary">
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
    		var date = new Date($("#dob").val());
			$("#realDob").val($("#dob").val());
			console.log($("#dob").val());
			
    		persistChanges("setup-account-post", "info", 1);
    	}

    	function saveDp(){
			persistChanges("save-dp", "dpForm", 2);
		}

    	function fileChosen(files){
			var file = event.target.files[0];
		    
		    if(file.type.match(/image.*/)) {
		        console.log('An image has been loaded');
		        var reader = new FileReader();
		        reader.onload = function (readerEvent) {
		        	tempImage = readerEvent.target.result;
		        	persistChanges("save-dp", "dpForm", 2);
		        	$("#dp").addClass('loading-dp');
		        	// $(".dp-uploader").removeAttr('disabled');
		        }
		        reader.readAsDataURL(file);
		    }
		    else{
		    	alert("Please choose an image!");
		    }
		}

		function goHome(){
			window.location.href = "/";
		}

		function persistChanges(url, form, callback){
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
					switch(callback){
						case 1:
							basicInfoSaved()
							break;
						case 2:
							dpSaved()
							break;
						case 3:
							dpSavedMob()
							break;
						default:
							phoneVerified()
							break;

					}
				}
				else{
					console.log("Error occured!", response);
					document.write(response.responseText);
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
		function phoneVerified(){
			setTimeout(function(){
				$("#phoneVerifiedAlert").show();

				setTimeout(function(){
					$("#phoneVerifiedAlert").hide();
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

		$("#town").geocomplete()
          .bind("geocode:result", function(event, result){
          	var loc = result.geometry.location;
          	$("#location").val(loc.lng() + ", " + loc.lat());
          })
          .bind("geocode:error", function(event, status){
            console.log("ERROR: " + status);
          })
          .bind("geocode:multiple", function(event, results){
            console.log("Multiple: " + results.length + " results found");
          });
        
        // $("#find").click(function(){
        //   $("#location").trigger("geocode");
        // });
    </script>
@endsection