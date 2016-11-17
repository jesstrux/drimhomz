@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <div id="profilePage" class="layout">
        <aside class="main-aside">
            <div class="layout end title-bar">
                <div>
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="u">{{ Auth::user()->role }}</p>
                </div>
            </div>

            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="javascript:void(0);" data-target="#pages">Pages</a></li>
                <li><a href="javascript:void(0);" data-target="#users">Manage Users</a></li>
                <li><a href="javascript:void(0);" data-target="#featuredhouses">Featured Houses</a></li>
            </ul>
        </aside>

        <div id="profileSections" class="flex">
            <div id="pages" class="subpage current">
                 <section class="short">
                    <div class="section-header text-center">
                        <h3>Pages</h3>
                        <p>
                            Here's are the site pages click the button below to add a new pages.<br>

                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Add new page</button>
                        </p>
                    </div>
                </section>
                <section class="layout center-justified">
                    <table class="page-table">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>URL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{$page->title}}</td>
                                    <td>{{$page->url}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>

            <div id="users" class="subpage">
                <section class="short">
                    <div class="section-header text-center">
                        <h3>Manage users</h3>
                        <p>
                            Here are the site users, click the button to manage or add a new one.<br>

                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Manage users</button>
                            <button class="round-btn dark" style="padding: 5px 20px; min-width: 0">New user</button>
                        </p>
                    </div>
                </section>
                <section class="layout center-justified">
                    <table class="page-table">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>ROLE</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <?php 
                                    $isMe = $user->id == Auth::user()->id;
                                    $isAdmin = $user->role == "admin";
                                ?>
                                @if(!$isMe)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>
                                            <button type="submit" class="btn dark btn-sm">Remove</button>
                                            @if($isAdmin)
                                                <button type="submit" class="btn material-blue btn-sm">Remove Admin</button>
                                            @else
                                                <button type="submit" class="btn material-blue btn-sm">Make Admin</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>

            <div id="featuredhouses" class="subpage">
                <section class="short">
                    <div class="section-header text-center">
                        <h3>Featured Houses ({{$today}})</h3>
                        <p>
                            To add a new house to the featured list, click the button below.<br>
                            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Add house</button>
                        </p>
                    </div>
                </section>

                <section>
                    <?php
                        $notnull = count($randomHouses) > 0;
                    ?>
                    @if($notnull)
                        <div style="padding: 0 30px; max-width: calc(100% - 60px); position: relative;" class="layout wrap">
                            @foreach($randomHouses as $house)
                                <?php
                                    $trailingS = $house->fav_count == 1 ? "" : "s";
                                    $likes_text = $house->fav_count. " like".$trailingS;

                                    $trailingS = $house->comment_count == 1 ? "" : "s";
                                    $comments_text = $house->comment_count. " comment".$trailingS;
                                ?>
                                <div class="dh-card" style="width: calc(33.333% - 20px); margin: 10px">
                                    <div class="image">
                                        <img src="{{asset($house->image_url)}}" alt="modern bath">
                                    </div>
                                    <div class="content">
                                        <h3>{{$house->title}}</h3>
                                        {{str_limit($house->description, $limit = 50, $end = '...')}}
                                        <span class="social-stuff">{{$likes_text}} | {{$comments_text}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-message">There are no featured houses.</div>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection