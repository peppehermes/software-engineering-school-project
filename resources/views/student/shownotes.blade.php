@extends('layouts.layout')

@section('content')

    <!-- Start Notes -->
    <div class="widgets-programs-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-hd text-center text-capitalize">
                        <div class="main-sparkline13-hd">
                            <h1>NOTES<span class="table-project-n"></span></h1>
                        </div>
                    </div>
                </div>
                @foreach($notes as $note)
                    <div class="float-lg-left col-lg-offset-1 col-lg-10
                     col-md-offset-2 col-md-8
                     col-sm-offset-2 col-sm-8
                     col-xs-12" style="margin-top: 30px">
                        <div class="hpanel">
                            <div class="panel-body">
                                <div class="stats-title pull-left">
                                    <h4>{{$note->subject}}</h4>
                                </div>
                                <div class="stats-icon pull-right">
                                    <i class="educate-icon educate-message"></i>
                                </div>
                                <div class="m-t-xl widget-cl-4">
                                    <h1 class="text-danger">{{$note->teachFirstName}} {{$note->teachLastName}}</h1>
                                    <div class="stats-row">
                                        <h6>{{$note->date}}</h6>
                                    </div>
                                    <small>{{$note->note}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Static Table Start -->
{{--    <div class="data-table-area mg-b-15">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
{{--                    <div class="sparkline13-list">--}}
{{--                        <div class="sparkline13-hd">--}}
{{--                            <div class="main-sparkline13-hd">--}}
{{--                                <h1>Notes<span class="table-project-n"></span></h1>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="sparkline13-graph">--}}
{{--                            <div class="datatable-dashv1-list custom-datatable-overright">--}}
{{--                                <div id="toolbar">--}}
{{--                                    <select class="form-control dt-tb">--}}
{{--                                        <option value="">Export Basic</option>--}}
{{--                                        <option value="all">Export All</option>--}}
{{--                                        <option value="selected">Export Selected</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <table id="table"data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"--}}
{{--                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>Date</th>--}}
{{--                                        <th>Subject</th>--}}
{{--                                        <th>Teacher</th>--}}
{{--                                        <th>Note</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}

{{--                                    @foreach($notes as $note)--}}

{{--                                    <tr>--}}
{{--                                        <td>{{$note->date}}</td>--}}
{{--                                        <td>{{$note->subject}}</td>--}}
{{--                                        <td>{{$note->teachFirstName}} {{$note->teachLastName}}</td>--}}
{{--                                        <td>{{$note->note}}</td>--}}
{{--                                    </tr>--}}

{{--                                    @endforeach--}}


{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- Static Table End -->

@endsection
