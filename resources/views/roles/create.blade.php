@extends('layouts.app')

@section('content')
    <style>
        #newRole{
            /*margin-top: 40px;*/
        }

        #newRole #outer{
            margin-top: 40px;
            max-width: 900px;
        }

        #newRole #wrapper{
            box-shadow: 0 0 2px rgba(0,0,0,0.35);
        }

        #newRole #dpEditor, #newRole #editorForm{
            padding: 35px 30px;
            /*background-color: purple;*/
        }


        #newRole #editorForm{
            padding-left: 60px;
        }

        #newRole #editorForm h3{
            margin-top: 0;
            color: #000;
        }




        #savebtnWrapper{
            margin-top: 30px;
        }

        #savebtnWrapper .btn{
            float: right;
        }

        @media all and (max-width: 780px) {
            #info{
                padding-top: 10px;
            }
            #newRole #outer{
                margin-top: 10px;
            }
            #newRole #wrapper{
                box-shadow: none;
            }

            #newRole #dpEditor{
                display: none;
            }

            #newRole #editorForm{
                padding: 10px;
                width: 100%;
            }

            .setup-field{
                width: 100%;
                -webkit-flex-direction: column;
                -moz-flex-direction: column;
                -ms-flex-direction: column;
                -o-flex-direction: column;
                flex-direction: column;
                -ms-align-items: flex-start;
                align-items: flex-start;
            }

            .setup-field label{

            }

            .setup-field .col-md-8{
                padding: 0;
                margin-top: 5px;
                width: 100%;
            }

            .setup-field .form-control{
                width: 100% !important;
            }
        }

        @media all and (min-width: 781px) {
            #editorForm{
                width: 96%
            }
            #info{
                padding-top: 30px;
            }
            #savebtnWrapper{
                margin-top: 30px;
                margin-right: 15px;
            }
        }
    </style>
    <div id="newRole">
        <div id="outer" class="container">
            <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
                <div id="editorForm">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>Create New Role</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                            </div>
                        </div>
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Display Name:</strong>
                                {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Description:</strong>
                                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                        {{ $value->display_name }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>
                        <div id="savebtnWrapper" class="form-group">
                            <button type="submit" class="btn btn-primary">
                                &emsp;Submit&emsp;
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection