<?php $has_menu = true; ?>
@extends('layouts.app')

@section('content')
    
    <style>
        .remove-admin-btn, .is-admin .add-admin-btn{
            display: none;
        }

        .is-admin .remove-admin-btn{
            display: inline-block;
        }
        @media only screen and (max-width: 760px) {
            .main-aside{
                -webkit-transform: translateX(-100%);
                -moz-transform: translateX(-100%);
                -ms-transform: translateX(-100%);
                -o-transform: translateX(-100%);
                transform: translateX(-100%);
            }
            #profileSections {
                -webkit-transform: translateX(-250px);
                -moz-transform: translateX(-250px);
                -ms-transform: translateX(-250px);
                -o-transform: translateX(-250px);
                transform: translateX(-250px);

                max-width: 100vw;
                min-width: 100vw;
                overflow: hidden;
                margin-top: -12px;
            }

            .main-aside, #profileSections {
                -webkit-transition: transform 0.25s ease-out;
                -moz-transition: transform 0.25s ease-out;
                -ms-transition: transform 0.25s ease-out;
                -o-transition: transform 0.25s ease-out;
                transition: transform 0.25s ease-out;;
            }

            .main-aside.open, .main-aside.open + #profileSections{
                -webkit-transform: none;
                -moz-transform: none;
                -ms-transform: none;
                -o-transform: none;
                transform: none;
            }
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
                openMenu();
            });
        });

        function openMenu(){
            $(".main-aside").toggleClass("open");
        }
    </script>
@endsection