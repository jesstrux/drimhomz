@extends('layouts.app')

@section('content')
    <div id="profilePage" class="layout" style="margin-top: -20px; paddin: 70px 100px; padding-top: 22px; background: #f9f9f9">
        <!-- <aside class="main-aside" style="displa: none;width:300px;background: #fff; box-shadow: 0 0 2px rgba(0,0,0,0.07); margin-right: 10px; border-right: 0;">
            <div class="layout end title-bar">
                <div>
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>

            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="javascript:void(0);" data-target="#about">Basic Info</a></li>
                <li><a href="javascript:void(0);" data-target="#myhouses">Houses</a></li>
                <li><a href="javascript:void(0);" data-target="#myalbums">Albums</a></li>
            </ul>
        </aside> -->

        <div id="profileSections" class="flex">
            <div id="about" class="subpage current">
                 <section class="short gradient">
                    <div class="section-header text-center">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p>
                            {{ Auth::user()->email }}
                        </p>
                        <p>
                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">
                                Edit profile
                            </button>
                            &nbsp;
                            <button class="round-btn light" style="padding: 5px 20px; min-width: 0">
                                New Album
                            </button>
                        </p>
                    </div>
                </section>
                <section class="layout center-justified">
                    <div class="panel panel-default" style="min-width: 400px">
                        <div class="panel-heading">Basic info</div>
                        <div class="panel-body">
                            Name: {{ Auth::user()->name }} <br>
                            Email: {{ Auth::user()->email }} <br>
                        </div>
                    </div>
                </section>
            </div>

            <div id="myhouses" class="subpage">
                <section class="short">
                    <div class="section-header text-center">
                        <h3>House pictures</h3>
                        <p>
                            Here are your houses, click button below to add a new one.<br>

                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">New picture</button>
                        </p>
                    </div>
                </section>
                <section></section>
            </div>

            <div id="myalbums" class="subpage">
                <section class="short">
                    <div class="section-header text-center">
                        <h3>House albums</h3>
                        <p>
                            Here are your albums, click the button below to create a new one. <br>
                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">New album</button>
                        </p>
                    </div>
                </section>

                <section></section>
            </div>
        </div>

        <div class="section-header text-center" style="padding: 20px; min-width: 30%">
            <h3>{{ Auth::user()->name }}</h3>
            <p>
                {{ Auth::user()->email }} <br>
                <button class="round-btn" style="padding: 5px 20px; min-width: 0">
                    Edit profile
                </button>
            </p>
        </div>
    </div>
@endsection