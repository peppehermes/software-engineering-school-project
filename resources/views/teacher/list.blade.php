@extends('layouts.layout')

@section('content')
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap drp-lst">
                        <h4>Teachers List</h4>
                        <div class="add-product">
                            <a href="/teacher/add">Add a new teacher</a>
                        </div>
                        <div class="asset-inner">
                            <table>
                                <tr>
                                    <th>Student Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date of birth</th>


                                </tr>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{$teacher->id}}</td>
                                        <td>{{$teacher->firstName}}</td>

                                        <td>{{$teacher->lastName}}</td>
                                        <td>{{$teacher->birthday}}</td>



                                        <td>
                                            <a href="/teacher/edit/{{$teacher->id}}"><button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                            <a href="/teacher/delete/{{$teacher->id}}"><button data-toggle="tooltip" title="Trash" class="pd-setting-ed"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        {!! $teachers->render() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
