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
                                <h1>Attendance List of {{$student->firstName}}</h1>
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
                                    <thead  class="thead-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Attendance status</th>
                                        <th>Description</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($attendanceReports as $attendanceReport)

                                        <tr>
                                            <td class="date">{{$attendanceReport->lectureDate}}</td>
                                            <td class="status">{{$attendanceReport->status}}</td>
                                            <td>
                                                @if($attendanceReport->presence_status =='full')
                                                    <span
                                                        style="color: darkgreen; font-weight: 500"> {{$attendanceReport->presence_status}}</span>
                                                @elseif($attendanceReport->presence_status =='late')
                                                    <span
                                                        style="color: darkred; font-weight: 500">{{$attendanceReport->presence_status}}</span>

                                                @elseif($attendanceReport->presence_status =='early')
                                                    <span
                                                        style="color: darkred; font-weight: 500">{{$attendanceReport->presence_status}}</span>

                                                @endif
                                            </td>
                                            <td class="desc">{{$attendanceReport->description}}</td>

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

{{--@extends('layouts.layout')--}}

{{--@section('content')--}}
{{--    <div class="data-table-area mg-b-15">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
{{--                    <div class="sparkline13-list">--}}
{{--                        <div class="sparkline13-hd">--}}
{{--                            <div class="main-sparkline13-hd">--}}
{{--                                <h1>Attendance List</h1>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="sparkline13-graph">--}}
{{--                            <div class="datatable-dashv1-list custom-datatable-overright">--}}
{{--                            <table id="table" data-toggle="table" data-pagination="true" data-search="true"--}}
{{--                                   data-show-columns="true" data-show-pagination-switch="true"--}}
{{--                                   data-show-refresh="true" data-key-events="true" data-show-toggle="true"--}}
{{--                                   data-resizable="true" data-cookie="true"--}}
{{--                                   data-cookie-id-table="saveId" data-show-export="true"--}}
{{--                                   data-click-to-select="true"--}}
{{--                                   data-toolbar="#toolbar">--}}
{{--                                <tr>--}}

{{--                                    <th>First Name</th>--}}
{{--                                    <th>Last Name</th>--}}
{{--                                    <th>Date</th>--}}
{{--                                    <th>Status</th>--}}
{{--                                    <th>Attendance status</th>--}}
{{--                                    <th>Description</th>--}}

{{--                                </tr>--}}
{{--                                @foreach($attendanceReports as $attendanceReport)--}}
{{--                                    <tr>--}}

{{--                                        <td>{{$attendanceReport->firstName}}</td>--}}
{{--                                        <td>{{$attendanceReport->lastName}}</td>--}}
{{--                                        <td>{{$attendanceReport->lectureDate}}</td>--}}
{{--                                        <td>{{$attendanceReport->status}}</td>--}}
{{--                                        <td>--}}
{{--                                            @if($attendanceReport->presence_status =='full')--}}
{{--                                                <button class="pd-setting">{{$attendanceReport->presence_status}}</button>--}}
{{--                                            @elseif($attendanceReport->presence_status =='late')--}}
{{--                                                <button class="ds-setting" >{{$attendanceReport->presence_status}}--}}
{{--                                                </button>--}}
{{--                                            @elseif($attendanceReport->presence_status =='early')--}}
{{--                                                <button class="ls-setting" >{{$attendanceReport->presence_status}}--}}
{{--                                                </button>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>{{$attendanceReport->description}}</td>--}}


{{--                                    </tr>--}}
{{--                                @endforeach--}}

{{--                            </table>--}}
{{--                        </div>--}}
{{--                        {!! $attendanceReports->render() !!}--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
