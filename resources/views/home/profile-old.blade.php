@extends('layouts.app')

@section('content')
    <div id="profilePage" class="layout">
        <aside class="main-aside">
            <div class="layout end title-bar">
                <div>
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>

            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="javascript:void(0);" data-target="#pages">Pages</a></li>
                <li><a href="javascript:void(0);" data-target="#users">Manage Users</a></li>
                <li><a href="javascript:void(0);" data-target="#featuredhouses">Featured Houses</a></li>
            </ul>
        </aside>

        <div id="profileSections" class="flex">
            <div id="about" class="subpage current">
                 <section class="short">
                    <div class="section-header text-center">
                        <h3>About you</h3>
                        <p>
                            Here's some info about yourself, click the button below to make some changes. <br>

                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Edit profile</button>
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
                        <h3>Dream pictures</h3>
                        <p>
                            Here are your dreams, click button below to add a new one.<br>

                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">New picture</button>
                        </p>
                    </div>
                </section>
                <section></section>
            </div>

            <div id="myalbums" class="subpage">
                <section class="short">
                    <div class="section-header text-center">
                        <h3>Dream albums</h3>
                        <p>
                            Here are your albums, click the button below to create a new one. <br>
                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">New album</button>
                        </p>
                    </div>
                </section>

                <section></section>
            </div>
        </div>
    </div>
@endsection