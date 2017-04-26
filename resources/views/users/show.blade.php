@extends('layouts.app')

@section('content')
    @include('users.style')
    <div id="newUser">
        <div id="outer" class="container">
            <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">

                <div id="dpEditor" class="flex">

                    <div  class="layout vertical center">


                        <div id="dp">
                            <?php
                            $dp = "images/uploads/user_dps/";
                            $dp = isset($user->dp) ? $user->dp : 'drimhomzDefaultDp.png' ;

                            ?>

                            <img src='{{asset("images/uploads/user_dps/$user->dp")}}' id="curDp" alt="">
                        </div>
                        <div class="layout">
                            <a class="btn btn-primary" href="{{'/user/'.$user->id}}">
                                View Professional Profile
                            </a>
                        </div>

                    </div>

                </div>
                <div id="editorForm">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>User Details</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div>
                        </div>
                    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>First Name:</strong>
                {{ $user->fname }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Last Name:</strong>
                {{ $user->lname }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Gender:</strong>
                {{ $user->gender }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Skills:</strong>
                {{ $user->skills }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Town:</strong>
                {{ $user->town }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Roles:</strong>

                @if(!empty($userRoles))
                    @foreach($userRoles as $v)
                        <label class="label label-success">{{ $v->display_name }}</label>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>
        </div>
    </div>
@endsection