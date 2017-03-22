@extends('layouts.app')

@section('content')
    @if (Auth::guest())
        <div id="banner" style="margin-top: -22px;">
            <div id="text">
                <h1>The house you've always wanted</h1>
                <p>How you've always wanted it</p>
                <a href="#" class="round-btn">Get Started</a>
            </div>
        </div>
        @include('home.guestview')
    @else
        @include('home.userview')
    @endif
@endsection