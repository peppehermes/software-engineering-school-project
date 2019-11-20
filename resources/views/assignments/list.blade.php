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
                                <h1>Topic<span class="table-project-n"></span>Table</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">

                                <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>
                                    <tr>
                                        <th data-field="date" data-editable="true">ClassRoom</th>
                                        <th data-field="prof" data-editable="true">Teacher</th>
                                        <th data-field="text">Text</th>
                                        <th data-field="subject" data-editable="true">Subject</th>
                                        <th data-field="topic" data-editable="true">Topic</th>
                                        <th data-field="date" data-editable="true">Date</th>
                                        <th data-field="deadline" data-editable="true">Deadline</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($assignments as $assignment)

                                        <tr>
                                            <td>{{$assignment->idClass}}</td>
                                            <td>{{$assignment->firstName}} {{$assignment->lastName}}</td>
                                            <td>{{$assignment->text}}</td>
                                            <td>{{$assignment->subject}} </td>
                                            <td>{{$assignment->topic}} </td>
                                            <td>{{$assignment->date}}</td>
                                            <td>{{$assignment->deadline}}</td>

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
