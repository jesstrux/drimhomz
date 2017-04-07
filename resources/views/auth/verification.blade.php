@extends('layouts.app')

        <!-- Main Content -->
@section('content')
    @include('layouts.header')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verify your phone number</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/verifyCode') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('verification_code') ? ' has-error' : '' }}">

                                <label for="email" class="col-md-4 control-label">Verification Code</label>

                                <div class="col-md-4">
                                    <input id="verification_code"  class="form-control" name="verification_code" value="{{ old('verification_code') }}" required>

                                    @if ($errors->has('verification_code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('verification_code') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <p>Enter the <small>verification code</small> we sent to your phone number</p>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Verify Phone number
                                    </button>
                                @if(Auth::check()&&!Auth::user()->verfified)
                                            <a class="btn btn-primary">
                                                Resend Code
                                            </a>
                                     @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
