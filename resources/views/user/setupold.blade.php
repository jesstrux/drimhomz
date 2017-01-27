@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <style>
    	#dp, #profile{
    		display: none;
    	}
    	#profile{
    		margin: auto;
    	}
    	#dp #image{
    		height: 250px;
    		width: 100%;
    		margin: auto;
    		background-color: #eee;
    		overflow: hidden;
    	}
    	#dp #image img{
    		width: 100%;
    		height: auto;
    	}
		@media all and (max-width: 600px) {
			#profile{
				margin: 0;
				left: 0;
				top: 0;
				width: 100vw;
				min-width: 100vw;
				box-shadow: none;
				margin-bottom: 10px;
			}
		}
		@media all and (min-width: 1100px) {
			#outer{
				padding: 20px;
			}
			.setup-field{
				width:550px;
				padding: 5px;
				display: inline-block;
			}

			#profile{
				display: block;
			}

			#dp #image{
				height: 300px;
				width: 350px;
				margin: auto;
				background-color: #eee;
			}
		}
	</style>
    <div id="outer" style="padding-top: 45px;">
    	<div class="layout">
    		<div id="profile" class="layout vertical">
				<div class="layout vertical end-justified long-header">
					<span id="name">{{$user->full_name()}}</span>
					<div class="profile-picture">
						<button id="uploaderOpener" onclick="showUploadArea()" class="camera-mask layout center-center">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3.2"/><path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/></svg>
						</button>
						<?php 
							$dp = "storage/app/";
							$dp.=isset($user->dp) ? $user->dp : 'images/dp.png' ;
						?>
						<img src='{{asset("images/uploads/$user->dp")}}' id="curDp" alt="">
					</div>
				</div>
				<div class="profile-body">
					<div class="divider">Full Name</div>
					<p>{{$user->full_name()}}</p>
					<div class="divider">Gender</div>
					<p id="genderText">{{$user->gender or "Unknown"}}</p>

					<div class="divider">Phone number</div>
					<p>{{$user->phone}}</p>

					<div class="divider">Town</div>
					<p id="townText">{{$user->town or "Unknown"}}</p>

					<div class="divider">Birthdate</div>
					<p id="dobText">
						<?php $birthdate = $user->birth_date(); ?>
						{{$birthdate or "Unknown"}}
					</p>
				</div>

				<div class="form-group" style="padding: 20px;">
					<button class="dp-uploader btn btn-primary btn-block hidden-lg" type="button" onclick="goHome()">
	                    Finish
	                </button>
	            </div>
			</div>

    		<div id="form" class="flex">
    			<div id="titleText">
			    	<h2 class="text-center">Finish setting up your profile</h2>
			    	<br><br>
			    </div>
        		<?php
        			$basicsDisplay = isset($user->gender) ? "none" : "";
        			$dpDisplay = isset($user->gender) ? "block" : "none";
        		?>
    			<div class="mode-dp" style="padding: 20px; padding-top: 0; text-align: center;">
    				<form id="info" style="display: {{$basicsDisplay}}" role="form" method="POST" action="{{ url('setup-account-post') }}">
	                    {{ csrf_field() }}
	                    <div class="setup-field form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
		                    <label for="gender" class="col-md-4 control-label">Gender</label>

		                    <div class="col-md-8">
		                        <select id="gender" class="form-control" name="gender" required>
		                        	<option value="">Choose an option</option>
		                        	<option value="Male">Male</option>
		                        	<option value="Female">Female</option>
		                        </select>

		                        @if ($errors->has('gender'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('gender') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>

		                <div class="setup-field form-group{{ $errors->has('town') ? ' has-error' : '' }}">
		                    <label for="gender" class="col-md-4 control-label">Town</label>

		                    <div class="col-md-8">
		                        <input id="town" placeholder="Town" type="text" class="form-control" name="town" value="{{ old('town') }}" required>

		                        @if ($errors->has('town'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('town') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>

		                <div class="setup-field form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
		                    <label for="gender" class="col-md-4 control-label">Date of birth</label>

		                    <div class="col-md-8">
		                        <input id="dob" type="date" class="form-control" value="{{ old('dob') }}" required>
		                        <input id="realDob" type="hidden" name="dob">

		                        @if ($errors->has('dob'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('dob') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>
		                <br>
                        <div class="form-group">
                            <button type="button" onclick="saveBasicInfo()" class="btn btn-primary">
                                Save and continue
                            </button>
                        </div>
                    </form>
	                <form id="dp" enctype="multipart/form-data" style="display: {{$dpDisplay}}" role="form" method="POST" action="{{ url('save-dp') }}">
	                	{{ csrf_field() }}

						<div id="image"><img></div>

						<h3>Profile picture</h3>
						<br>
						<div class="form-group">
							<input type="file" id="filePicker" name="dp" class="hidden" onchange="fileChosen()">

							<label for="filePicker" class="btn theme-color">
                                &nbsp;Choose picture&nbsp;
                            </label>

                            <button type="button" class="dp-uploader btn btn-primary hidden-xs hidden-sm hidden-md" disabled onclick="saveDp()">
                                &nbsp;Upload&nbsp;
                            </button>

                            <button type="button" class="dp-uploader btn btn-primary hidden-lg" disabled onclick="saveDpThenPreview()">
                                &nbsp;Upload&nbsp;
                            </button>
                        </div>
					</form>
    			</div>
    		</div>
    	</div>
    </div>

    <script>
    	$(document).on("keyup", ".setup-field input", function(){
    		liveUpdate($(this), $(this).val());
    	});
    	$(document).on("change", ".setup-field select, .setup-field #dob", function(){
    		liveUpdate($(this), $(this).val());
    	});

    	function liveUpdate(el, val){
    		var id = el.prop("id")+"Text";
    		val = val.length ? val : "Unknown";
			$("#"+id).text(val);

			if(id == "dobText"){
				var date = new Date($("#dob").val());
    			$("#realDob").val($("#dob").val());
    			console.log($("#dob").val());
			}
    	}

    	function saveBasicInfo(){
    		persistChanges("setup-account-post", "info", 1);
    	}

    	function saveDp(){
			persistChanges("save-dp", "dp", 2);
		}

		function saveDpThenPreview(){
    		persistChanges("save-dp", "dp", 3);
		}

    	function fileChosen(files){
			var file = event.target.files[0];
			var image = $("#dp img, #curDp");
		    // Ensure it's an image
		    if(file.type.match(/image.*/)) {
		        console.log('An image has been loaded');
		        var reader = new FileReader();
		        reader.onload = function (readerEvent) {
		        	image.attr("src", readerEvent.target.result);
		        	$(".dp-uploader").removeAttr('disabled');
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
			// var form = document.forms.namedItem(form);
			// var formElement = $("#"+form);
			// var formData = new FormData($("#"+form)[0]);
			// console.log(formData.get("gender"));
			// console.log(formData.get("town"));
			// console.log(formData.get("dob"));
			
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
					}
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
    		$("#info").fadeOut('slow', function() {
    			$("#dp").fadeIn("fast");
    		});
    	}

    	function dpSaved(){
    		goHome();
    	}

    	function dpSavedMob(){
    		$("#form").fadeOut('slow', function() {
    			$("#profile").fadeIn("fast");

    			$("#titleText").hide();
    		});
    	}
    </script>
@endsection
