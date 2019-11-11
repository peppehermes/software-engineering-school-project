@extends('layouts.layout')

@section('content')
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap drp-lst">
                        <h4>Users List</h4>
                        <div class="add-product">
                            <a href="/user/add">Add a new user</a>
                        </div>
                        <div class="asset-inner">
                            <table>
                                <tr>
                                    <th>User Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>

                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>

                                        <td>{{$user->email}}</td>


                                        <td>

                                            @if($user->roleId)
                                                <button
                                                    class="pd-setting">@foreach($roles as $role)@if($user->roleId == $role->id) {{$role->name}} @endif @endforeach</button>
                                            @else
                                                <button class="ds-setting" style=" pointer-events: none;">No class
                                                </button>
                                            @endif

                                        </td>


                                        <td>
                                            <a href="/user/edit/{{$user->id}}">
                                                <button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </a>
                                            <a href="/user/delete/{{$user->id}}">
                                                <button data-toggle="tooltip" title="Trash" class="pd-setting-ed"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        {!! $users->render() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
