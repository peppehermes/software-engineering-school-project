@extends('layouts.layout')

@section('content')
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Students List for Class {{$classId}}</h1>
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
                                <form id="form" method="post"
                                      action="/student/saveattendance/{{$classId}}">


                                    <div class="form-group data-custon-pick" id="data_2">
                                        <label>
                                            <Today></Today>
                                        </label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="lectureDate" class="form-control"
                                                   id="attendaceDate"
                                                   value="{{$date}}" classId="{{$classId}}" onchange="changeDate();">


                                        </div>


                                    </div>

                                    @csrf
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                           data-show-columns="true" data-show-pagination-switch="true"
                                           data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                           data-resizable="true" data-cookie="true"
                                           data-cookie-id-table="saveId" data-show-export="true"
                                           data-click-to-select="true"
                                           data-toolbar="#toolbar">

                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Presence Status</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <input type="text" hidden name="frm{{$student->id}}[studentId]"
                                                       value="{{$student->id}}">
                                                <td><input type="checkbox" name="frm{{$student->id}}[status]" value="1"
                                                           @if(isset($student->attendance) && $student->attendance->status =='present') checked @endif>
                                                </td>
                                                <td>{{$student->firstName}}</td>
                                                <td>{{$student->lastName}}</td>
                                                <td><select class="form-control dt-tb"
                                                            name="frm{{$student->id}}[presence_status]">
                                                        <option value="full"
                                                                @if(isset($student->attendance) && $student->attendance->presence_status=='full')selected @endif >
                                                            full
                                                        </option>
                                                        <option value="late"
                                                                @if(isset($student->attendance) && $student->attendance->presence_status=='late')selected @endif >
                                                            late
                                                        </option>
                                                        <option value="early"
                                                                @if(isset($student->attendance) &&  $student->attendance->presence_status=='early')selected @endif >
                                                            early
                                                        </option>
                                                    </select>
                                                </td>
                                                <td><textarea name="frm{{$student->id}}[description]"
                                                              cols="50">@if(isset($student->attendance) ){{$student->attendance->description}} @endif</textarea>
                                                </td>


                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row" style="margin-top:50px;">
                                        <div class="col-lg-12">
                                            <div class="payment-adress">
                                                <button type="submit"
                                                        class="btn btn-primary btn-lg center-block" @if(date('d/m/Y') != $date) disabled @endif>
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

    <script>
        function changeDate() {


            var date = document.getElementById('attendaceDate').value;
            var classId = document.getElementById("attendaceDate").getAttribute("classId");

            var newmystr = date.split('/');
            date = newmystr[2] + '-' + newmystr[1] + '-' + newmystr[0];


            window.location.href = "/student/attendance/" + classId + "/" + date;
        }

    </script>
@endsection
