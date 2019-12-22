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
                                <h1>You are the Coordinator for Class {{$classId}}</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <a href="/finalgrades/download/{{$classId}}">Click here to download a template of final grades</a>
                                {{--                                <div id="toolbar">--}}
                                {{--                                    <select class="form-control dt-tb">--}}
                                {{--                                        <option value="">Export Basic</option>--}}
                                {{--                                        <option value="all">Export All</option>--}}
                                {{--                                        <option value="selected">Export Selected</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <form id="form" method="post"
                                      action="/finalgrades/store/{{$classId}}"
                                      onsubmit="return confirm('Are you sure? Final grades cannot be changed');">

                                    @csrf
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                           data-show-columns="true" data-show-pagination-switch="true"
                                           data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                           data-resizable="true" data-cookie="true"
                                           data-cookie-id-table="saveId" data-show-export="true"
                                           data-click-to-select="true"
                                           data-toolbar="#toolbar">

                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Student</th>
                                            @foreach($subjects as $subject)
                                                <th>{{$subject->subjectName}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                            <tr>

                                                <td>{{$student->firstName}} {{$student->lastName}}</td>
                                                @foreach($subjects as $subject)
{{--                                            for each student and subject I'm passing an array of [studentId, subjectId, finalgrade]--}}
                                                    <input type="text" hidden name="frm{{$student->id}}{{$subject->subjectId}}[idStudent]"
                                                           value="{{$student->id}}">
                                                    <input type="text" hidden name="frm{{$student->id}}{{$subject->subjectId}}[idSubject]"
                                                           value="{{$subject->subjectId}}">
                                                    <td><select class="form-control dt-tb"
                                                                name="frm{{$student->id}}{{$subject->subjectId}}[finalgrade]">
                                                            @for ($i = 2; $i <= 10; $i++)
                                                                <option value="{{$i}}" @if($i == 6) selected="selected" @endif >
                                                                    {{$i}}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row" style="margin-top:50px;">
                                        <div class="col-lg-12">
                                            <div class="payment-adress">
                                                <button type="submit"
                                                        class="btn btn-primary btn-lg center-block">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
