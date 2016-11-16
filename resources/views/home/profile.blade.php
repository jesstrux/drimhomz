@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <div class="layout">
        <aside style="min-width:250px;height: inherit; margin-top: -22px; background: #f9f9f9; min-height: calc(100vh - 60px)">
            <div class="layout end" style="height: 200px; padding: 16px; background: #555; color: #fff">
                {{ Auth::user()->name }}
            </div>

            <ul class="nav">
                <li><a href="#">About</a></li>
                <li><a href="#">Pictures</a></li>
                <li><a href="#">Albums</a></li>
            </ul>
        </aside>
        <div class="flex">
            <section id="pictures" class="short">
                <div class="section-header text-center">
                    <h3>About you</h3>
                    <p>
                        Here's some info about yourself, click the button below to make some changes.

                        <button class="round-btn" style="padding: 5px 20px; min-width: 0">Edit profile</button>
                        <!-- <button class="round-btn dark" style="padding: 5px 20px; min-width: 0">Change password</button> -->
                    </p>
                </div>
            </section>
        </div>
    </div>
@endsection