@extends('layouts.app')

@section('content')
    @include('users.style')
    <div id="newUser">
        <div id="outer" class="container">
            <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
                <div id="dpEditor" class="flex">

                    <form id="dpForm" enctype="multipart/form-data" role="form" method="POST"
                          action="{{ url('save-dp') }}" class="layout vertical center">
                        {{ csrf_field() }}

                        <div id="dp">
                            <?php
                            $dp = "images/uploads/user_dps/";
                            $dp = isset($user->dp) ? $user->dp : 'drimhomzDefaultDp.png';

                            ?>

                            <div id="loadingDp" class="layout center-center">
                                <img src="{{asset('images/loading.gif')}}" alt="">
                            </div>

                            <img src='{{asset("images/uploads/user_dps/$user->dp")}}' id="curDp" alt="">
                        </div>
                    </form>

                    <br>
                    <div id="dpSavedAlert" class="alert alert-success alert-dismissible collapse" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        Picture saved.
                    </div>

                </div>
                <div id="editorForm">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>Edit User</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div>
                        </div>
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>First Name:</strong>
                                {!! Form::text('fname', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Last Name:</strong>
                                {!! Form::text('lname', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Phone:</strong>
                                {!! Form::text('phone', null, array('placeholder' => 'Phone Number','class' => 'form-control phoneNumber')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                                <strong>Town:</strong>
                                <input id="town" placeholder="Town" type="text" class="form-control" name="town"
                                       value="{{$user->town}}" required>

                                @if ($errors->has('town'))
                                    <span class="help-block">
		                                <strong>{{ $errors->first('town') }}</strong>
		                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Location:</strong>
                                <input id="location" readonly placeholder="location" type="text" class="form-control" name="location" value="{{$user->location_str()}}" required>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Role:</strong>
                                <br/>
                                @foreach($role as $value)
                                    <label>{{ Form::checkbox('role[]', $value->id, in_array($value->id, $userRoles) ? true : false, array('class' => 'name')) }}
                                        {{ $value->display_name }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    <script src="http://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBgc2zYiUzXGjZ277annFVhIXkrpXdOoXw"></script>
    <script src="{{asset('js/jquery.geocomplete.min.js')}}"></script>
    <script>

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
    </script>
@endsection