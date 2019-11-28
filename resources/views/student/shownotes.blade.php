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
                                <h1>Notes<span class="table-project-n"></span></h1>
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
                                <table id="table"data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Note</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($notes as $note)

                                    <tr>
                                        <td>{{$note->date}}</td>
                                        <td>{{$note->subject}}</td>
                                        <td>{{$note->teachFirstName}} {{$note->teachLastName}}</td>
                                        <td>{{$note->note}}</td>
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
