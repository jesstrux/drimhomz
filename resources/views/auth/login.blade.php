@extends('auth.wrapper')

@section('content')

    <style>
        @media only screen and (max-width: 760px) {
            #container{
                width: 98%;
            }
        }
    </style>
<div id="container" class="container" style="max-width: 800px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Drimhomz Login <a class="pull-right" href="{{url('')}}">Home</a>
                </div>
                <br>
                <div class="panel-body">
                    <center>
                        No account yet? <a href="/register">Register</a>
                    </center>
                    <br>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control phoneNumber" onchange="setPhone()" value="{{ old('phone') }}" required>
                                <span id="valid-msg" class="hide">✓ Valid</span>
                                <span id="error-msg" class="hide">Invalid number</span>
                                <input type="hidden" name="phone" id="phone_no" value="{{ old('phone_number') }}">

                                {{--<input id="phon" name="phone" type="tel" class="form-control" value="{{ old('phone') }}" required>--}}
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
