@extends('layouts.layout')

@section('content')

    <!-- Static Table Start -->
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Your Meetings<span class="table-project-n"></span></h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                {{--                                <div id="toolbar">--}}
                                {{--                                    <select class="form-control dt-tb">--}}
                                {{--                                        <option value="">Export Basic</option>--}}
                                {{--                                        <option value="all">Export All</option>--}}
                                {{--                                        <option value="selected">Export Selected</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                       data-show-columns="true" data-show-pagination-switch="true"
                                       data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                       data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                       data-toolbar="#toolbar" class="table-striped table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Week</th>
                                        <th>Prof</th>
                                        <th>Day</th>
                                        <th>Hour</th>
                                        <th>Student</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($meetings as $meeting)

                                        <tr>
                                            <td>{{$meeting->idweek}}</td>
                                            <td>{{$meeting->teachFirstName}} {{$meeting->teachLastName}}</td>
                                            <td>{{$meeting->day}}</td>
                                            <td>{{$meeting->hour}}</td>
                                            <td>{{$meeting->studFirstName}} {{$meeting->studLastName}}</td>

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
