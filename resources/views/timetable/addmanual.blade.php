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
                                <h1>Class {{$classId}}</h1>
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
                                      action="/timetable/storemanual/{{$classId}}"
                                      onsubmit="return confirm('Are you sure there are no constraints? If so, proceed.');">

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
                                            <th>Hour/Day</th>
                                            <th>Monday</th>
                                            <th>Tuesday</th>
                                            <th>Wednesday</th>
                                            <th>Thursday</th>
                                            <th>Friday</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>8:00</td>
                                                @for ($i = 1; $i < 26; $i = $i+6)
                                                <td><select class="form-control dt-tb"
                                                            name="frm{{$i}}">
                                                        @foreach ($subjects as $subject)
                                                            <option value="{{$subject->id}}" @if($subject->subject == "Italian") selected="selected" @endif >
                                                                {{$subject->subject}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                @endfor
                                            </tr>

                                            <tr>
                                                <td>9:00</td>
                                                @for ($i = 2; $i < 27;  $i = $i+6)
                                                    <td><select class="form-control dt-tb"
                                                                name="frm{{$i}}">
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{$subject->id}}" @if($subject->subject == "Italian") selected="selected" @endif >
                                                                    {{$subject->subject}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endfor
                                            </tr>

                                            <tr>
                                                <td>10:00</td>
                                                @for ($i = 3; $i < 28;  $i = $i+6)
                                                    <td><select class="form-control dt-tb"
                                                                name="frm{{$i}}">
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{$subject->id}}" @if($subject->subject == "Italian") selected="selected" @endif >
                                                                    {{$subject->subject}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endfor
                                            </tr>

                                            <tr>
                                                <td>11:00</td>
                                                @for ($i = 4; $i < 29;  $i = $i+6)
                                                    <td><select class="form-control dt-tb"
                                                                name="frm{{$i}}">
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{$subject->id}}" @if($subject->subject == "Italian") selected="selected" @endif >
                                                                    {{$subject->subject}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endfor
                                            </tr>

                                            <tr>
                                                <td>12:00</td>
                                                @for ($i = 5; $i < 30;  $i = $i+6)
                                                    <td><select class="form-control dt-tb"
                                                                name="frm{{$i}}">
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{$subject->id}}" @if($subject->subject == "Italian") selected="selected" @endif >
                                                                    {{$subject->subject}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endfor
                                            </tr>


                                            <tr>
                                                <td>13:00</td>
                                                @for ($i = 6; $i < 31;  $i = $i+6)
                                                    <td><select class="form-control dt-tb"
                                                                name="frm{{$i}}">
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{$subject->id}}" @if($subject->subject == "Italian") selected="selected" @endif >
                                                                    {{$subject->subject}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endfor
                                            </tr>

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
