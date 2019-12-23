@extends('layouts.layout')

@section('content')

    <!-- Static Table Start -->
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Marks<span class="table-project-n"> of Class {{$classId}}</span></h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">

                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                       data-show-columns="true" data-show-pagination-switch="true"
                                       data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                       data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                       data-toolbar="#toolbar" class="table-striped table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>ClassRoom</th>
                                        <th>Teacher</th>
                                        <th>Grade</th>
                                        <th>Subject</th>
                                        <th>Topic</th>
                                        <th>Student</th>
                                        <th>Date</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($marks as $mark)

                                        <tr>
                                            <td>{{$mark->idClass}}</td>
                                            <td>{{$mark->firstName}} {{$mark->lastName}}</td>
                                            <td>@php if(strpos($mark->mark,'.25')) echo str_replace('.25','+',$mark->mark); elseif(strpos($mark->mark,'.75')) echo (intval($mark->mark)+1).'-'; else echo $mark->mark;  @endphp</td>
                                            <td>{{$mark->subject}} </td>
                                            <td>{{$mark->topic}} </td>
                                            <td>{{$mark->studentName}} {{$mark->studentSurname}}</td>
                                            <td>{{$mark->date}}</td>


                                        </tr>

                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Static Table End -->



@endsection
