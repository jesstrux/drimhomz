@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <style>
        .remove-admin-btn, .is-admin .add-admin-btn{
            display: none;
        }

        .is-admin .remove-admin-btn{
            display: inline-block;
        }
    </style>
    <div id="profilePage" class="layout">
        <aside class="main-aside">
            <div class="layout end title-bar">
                <div>
                    <h4>{{ Auth::user()->full_name() }}</h4>
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
                                <th>PHONE</th>
                                <th>ROLE</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($users) < 2)
                                <tr>
                                    <td colspan="4">No users</td>
                                </tr>
                            @endif

                            @foreach($users as $user)
                                <?php 
                                    $isMe = $user->id == Auth::user()->id;
                                    $isAdmin = $user->role == "admin" ? "is-admin" : "";
                                ?>
                                @if(!$isMe)
                                    <tr>
                                        <td>{{$user->full_name()}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>
                                            <form id="addAdmin{{$user->id}}" role="form" method="POST" action="{{ url('make-admin') }}" class="{{$isAdmin}}">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                
                                                <button type="submit" class="btn dark btn-sm">Remove</button>

                                                <button type="button" class="remove-admin-btn btn btn-default btn-sm" onclick="toggleAdmin('toggle-admin', {{$user->id}})">Remove Admin</button>

                                                <button type="button" class="add-admin-btn btn material-blue btn-sm" onclick="toggleAdmin('toggle-admin', {{$user->id}})">Make Admin</button>
                                            </form>
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

    <script>
        $(document).ready(function(){
            $(document).on("click", '#profilePage aside a', function(){
                var curIdx = $('#profilePage aside li.active').index();
                var nextIdx = $(this).parents("li").index();
                var animDir = curIdx > nextIdx ? "down" : "up";
                var target = $(this).data('target');

                $('#profilePage aside li.active').removeClass('active');
                $(this).parents("li").addClass('active');
                $('#profilePage .subpage.current').removeClass('current');
                $(target).addClass('current');
                // console.log(curIdx, nextIdx ,animDir);
            });
        });

        function toggleAdmin(url, id){
            var formdata = new FormData($("#addAdmin"+id)[0]);
            formdata.append('id', id);

            $.ajax({
                  type:'POST',
                  url: url,
                  data: formdata,
                  dataType:'json',
                  async:false,
                  processData: false,
                  contentType: false
            })
            .done(function(response){
                console.log("Response!, ", response);
                if(response.success){
                    console.log("Switching now!!!");
                    $("#addAdmin"+id).toggleClass('is-admin');
                }
            })
            .fail(function(response){
                console.log("Response!, ", response);
            })
            .always(function(){
                console.log("Action done");
            });
        }
    </script>
@endsection