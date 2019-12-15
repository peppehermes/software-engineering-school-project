@extends('layouts.layout')

@section('content')
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
                                <h1>Final Grades for Class {{$classId}}</h1>
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
                                           data-cookie-id-table="saveId" data-show-export="true"
                                           data-click-to-select="true"
                                           data-toolbar="#toolbar">

                                    <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        @foreach($subjects as $subject)
                                            <th>{{$subject->subjectName}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($students as $student)
                                        <tr>

                                            <td>{{$student->firstName}}</td>
                                            <td>{{$student->lastName}}</td>
                                            @foreach($subjects as $subject)
                                                @foreach($finalgrades as $finalgrade)
{{--
                                                    print the final grade for each subject
--}}
                                                    @if($finalgrade->idStudent == $student->id
                                                    && $finalgrade->idSubject == $subject->subjectId)
                                                        <td>{{$finalgrade->finalgrade}}</td>
                                                    @endif
                                                @endforeach
                                            @endforeach
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
@endsection
