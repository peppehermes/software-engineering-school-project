@extends('layouts.layout')

@section('content')
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap drp-lst">
                        <h4>Classroom List</h4>
                        <div class="add-product">
                            <a href="/classroom/add">Add a new class</a>
                        </div>
                        <div class="asset-inner">
                            <table>
                                <tr>
                                    <th>Class Id</th>
                                    <th>Capacity</th>
                                    <th>Fill the class</th>

                                </tr>
                                @foreach($classrooms as $classroom)
                                    <tr>
                                        <td>{{$classroom->id}}</td>
                                        <td>{{$classroom->capacity}}</td>

                                        <td>
                                            @if($classroom->id)
                                                <a href="/classroom/composition/{{$classroom->id}}">
                                                    <button class="pd-setting">Class Composition</button>
                                                </a>
                                            @else
                                                <button class="ds-setting" style=" pointer-events: none;">No class
                                                </button>
                                            @endif
                                        </td>


                                        <td>
                                            <a href="/classroom/edit/{{$classroom->id}}">
                                                <button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </a>
                                            <a href="/classroom/delete/{{$classroom->id}}">
                                                <button data-toggle="tooltip" title="Trash" class="pd-setting-ed"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        {!! $classrooms->render() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
