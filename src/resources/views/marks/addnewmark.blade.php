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
                                <h1>Students List </h1>

                            </div>
                        </div>
                        <br>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                {{--                                <div id="toolbar">--}}
                                {{--                                    <select class="form-control dt-tb">--}}
                                {{--                                        <option value="">Export Basic</option>--}}
                                {{--                                        <option value="all">Export All</option>--}}
                                {{--                                        <option value="selected">Export Selected</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <form id="demo1-upload" enctype="multipart/form-data"
                                      onsubmit="checkDate()" name="form">


                                    <div class="row">

                                        <div class="form-group data-custon-pick col-md-3" id="data_2">
                                            <label>
                                                Date:
                                            </label>
                                            <div class="input-group date">
                                                    <span class="input-group-addon"><i
                                                            class="fa fa-calendar"></i></span>
                                                <input type="text" name="lecturedate" class="form-control"
                                                       value="{{$date}}">


                                            </div>


                                        </div>

                                        <div class="form-group col-md-3">

                                            <label>Class:</label>
                                            <select onchange="getStudentsandSubjects()"
                                                    name="idClass" id="idClass" class="form-control"
                                                    required>
                                                <option hidden disabled selected></option>
                                                @foreach($classes as $class)
                                                    <option
                                                        value="{{$class->idClass}}"
                                                        @if($classId == $class->idClass) selected @endif>{{$class->idClass}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label>Subject:</label>
                                            <select name="subject" id="subject" class="form-control"
                                                    required>
                                                @foreach($subjectsClass as $item)
                                                    <option @if($item->subject==$subject) selected
                                                            @endif value="{{$item->subject}}">{{$item->subject}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Topic:</label>
                                            <input name="topic" type="text"
                                                   class="form-control" required value="{{$topic}}">
                                        </div>


                                        <div class="form-group col-md-3">

                                            <button type="submit"
                                                    class="btn filters">
                                                Search
                                            </button>

                                        </div>
                                    </div>

                                </form>
                                <form id="form" method="post"
                                      action="/mark/storenewmark">
                                    <input type="hidden" name="classId" value="{{$classId}}">
                                    <input type="hidden" name="subject" value="{{$subject}}">
                                    <input type="hidden" name="topic" value="{{$topic}}">
                                    <input type="hidden" name="date" value="{{$date}}">
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
                                            <th>Mark</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <input type="text" hidden name="frm{{$student->id}}[idStudent]"
                                                       value="{{$student->id}}">
                                                <td><input type="checkbox" name="frm2{{$student->id}}[status]"
                                                           value="1">
                                                </td>
                                                <td>{{$student->firstName}}</td>
                                                <td>{{$student->lastName}}</td>

                                                <td>

                                                    <select id="mark" name="frm{{$student->id}}[mark]" type="float"
                                                            class="form-control mark"
                                                            required>

                                                        <option selected value="0">Select</option>
                                                        @for($i=1  ; $i<10.5 ; $i=$i+0.25)
                                                            <option @if($i == $student->mark) selected @endif
                                                            value="{{$i}}">@php if(strpos($i,'.25')) echo str_replace('.25','+',$i); elseif(strpos($i,'.75')) echo (intval($i)+1).'-'; else echo $i;  @endphp</option>
                                                        @endfor

                                                    </select>

                                                </td>


                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row" style="margin-top:50px;">
                                        <div class="col-lg-12">
                                            <div class="payment-adress">
                                                <button type="submit"
                                                        class="btn btn-primary btn-lg center-block"
                                                        @if(date('d/m/Y') != $date) disabled @endif>
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

        function markvalue() {

            var selector = document.getElementById("range"),
                mark = document.getElementById("mark");

            mark.value = selector.value;
        }

        function getStudentsandSubjects() {
            var idClass = document.getElementById("idClass").value,
                subject = document.getElementById("subject"),
                l = subject.length


            for (i = 0; i < l; i++) {
                subject.remove(0);
            }


            @foreach($subjects as $subject)
            if ("{{$subject->idClass}}" === idClass) {
                var opt1 = document.createElement('OPTION');
                opt1.text = "{{$subject->subject}} ";
                opt1.value = "{{$subject->subject}}";
                subject.appendChild(opt1);
            }
            @endforeach
        }


        function checkDate() {

            var extraday, d, m;

            var date = document.getElementById('lecturedate').value;
            var str = date.split('/');
            d = str[0];
            m = str[1];


            const today = new Date(),
                dayweek = today.getDay(),
                daymonth = today.getDate(),
                month = today.getMonth() + 1,
                lastday = daymonth - dayweek + (dayweek == 0 ? -6 : 1);

            if (lastday <= 0) {

                if (month == 5 || month == 7 || month == 10 || month == 12)
                    extraday = 30 + lastday;

                else if (month == 3)
                    extraday = 28 + lastday;

                else
                    extraday = 31 + lastday;

            }

            if ((lastday <= d && d <= daymonth && m == month)
                || (lastday <= 0 && extraday <= d && m == month - 1)
                || (lastday <= 0 && d <= daymonth && m == month)) {

                document.getElementById('demo1-upload').action = "/mark/addnewmark";
                document.getElementById('demo1-upload').method = "get";


            } else {
                alert("Wrong  date!");
                document.getElementById('day').focus();
                document.getElementById('year').focus();
                document.getElementById('month').focus();
            }

        }


    </script>
@endsection
