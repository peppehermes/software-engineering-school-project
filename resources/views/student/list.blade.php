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
                        <h4>Students List</h4>
                        <div class="add-product">
                            <a href="/student/add">Add a new student</a>
                        </div>
                        <div class="asset-inner">
                            <table>
                                <tr>
                                    <th>Student Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date of birth</th>
                                    <th>Class</th>

                                </tr>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{$student->id}}</td>
                                        <td>{{$student->firstName}}</td>

                                        <td>{{$student->lastName}}</td>
                                        <td>{{$student->birthday}}</td>
                                        <td>
                                            @if($student->classId)
                                                <button class="pd-setting">{{$student->classId}}</button>
                                            @else
                                                <button class="ds-setting" style=" pointer-events: none;">No class
                                                </button>
                                            @endif
                                        </td>


                                        <td>
                                            <a href="/student/edit/{{$student->id}}"><button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                            <a href="/student/delete/{{$student->id}}"><button data-toggle="tooltip" title="Trash" class="pd-setting-ed"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        {!! $students->render() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
