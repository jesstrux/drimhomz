@extends('layouts.app')

@section('content')
    
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
                <li class="active"><a href="javascript:void(0);" data-target="#ads">Featured Ads</a></li>
                <li><a href="javascript:void(0);" data-target="#pages">Pages</a></li>
                <li><a href="javascript:void(0);" data-target="#users">Manage Users</a></li>
            </ul>
        </aside>

        <div id="profileSections" class="flex">
            <div id="ads" class="subpage current">
                @include('dashboard.ads')
            </div>

            <div id="pages" class="subpage">
                @include('dashboard.pages')
            </div>

            <div id="users" class="subpage">
                @include('dashboard.users')
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
    </script>
@endsection