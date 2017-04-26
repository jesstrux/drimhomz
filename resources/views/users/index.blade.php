@extends('layouts.app')

@section('content')
    @include('users.style')
    <div id="newUser">
        <div id="outer" class="container">
            <div id="wrapper" class="layout" style="background-color: #fff; margin-bottom: 40px;">
                <div id="editorForm">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>User Management</h2>
                            </div>
                            <div class="pull-right">
                                @permission('role-create')
                                <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
                                @endpermission
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td><img src="images/uploads/user_dps/{{ $user->dp }}" class="img-circle" style="position: relative;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    overflow: hidden;"></td>
                                <td>{{ $user->fname }} {{ $user->lname }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                    @permission('role-edit')
                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                    @endpermission
                                    @permission('role-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $users->render() !!}
                </div>
            </div>
        </div>
    </div>

@endsection