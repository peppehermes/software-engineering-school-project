@extends('layouts.layout')

@section('content')



    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            @if ($full==1)
                                <div class="alert alert-danger">
                                    <ul>

                                        <li>Class {{$classroom->id}} is full!</li>

                                    </ul>
                                </div>
                            @endif
                            <div class="main-sparkline13-hd">
                                <h1>Classroom {{$classroom->id}} ( <span
                                        class="text-danger font-bold">Capacity {{$classroom->capacity}}</span> )

                                </h1>

                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">

                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                       data-show-columns="true" data-show-pagination-switch="true"
                                       data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                       data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                       data-toolbar="#toolbar">
                                    <thead>
                                    <tr>
                                        <th data-field="id">ID</th>
                                        <th data-field="name" data-editable="true">First Name</th>
                                        <th data-field="email" data-editable="true">Last Name</th>
                                        <th data-field="phone" data-editable="true">Birthday</th>
                                        <th data-field="complete">Phone</th>
                                        <th data-field="task" data-editable="true">Gender</th>
                                        <th data-field="task" data-editable="true">Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($studentsList as $student)
                                        <tr>

                                            <td>{{$student->id}}</td>
                                            <td>{{$student->firstName}}</td>
                                            <td>{{$student->lastName}}</td>
                                            <td>{{$student->birthday}}</td>
                                            {{--                                            <td class="datatable-ct"><span class="pie">1/6</span>--}}
                                            {{--                                            </td>--}}
                                            <td>{{$student->phone}}</td>
                                            <td>{{$student->gender}}</td>
                                            <td><a href="/classroom/deleteStudent/{{$student->id}}">
                                                    <button class="pd-setting">Remove of this class</button>
                                                </a>
                                            </td>

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

    <div class="dual-list-box-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline10-list">
                        <div class="sparkline10-hd">
                            <div class="main-sparkline10-hd">
                                <h1>Add students to this class</h1>
                            </div>
                        </div>
                        <div class="sparkline10-graph">
                            <div class="basic-login-form-ad">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="dual-list-box-inner">
                                            <form id="form" method="post"
                                                  action="/classroom/classComposition/{{$classroom->id}}"
                                                  class="wizard-big">
                                                @csrf
                                                <select class="form-control dual_select" name="frm[]" multiple>
                                                    @foreach($students as $student)
                                                        <option
                                                            value="{{$student->id}}">{{$student->firstName.' '.$student->lastName}}</option>

                                                    @endforeach

                                                </select>

                                                <div class="row" style="margin-top:50px;">
                                                    <div class="col-lg-12">
                                                        <div class="payment-adress">
                                                            <button type="submit" @if($full==1) disabled @endif
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
            </div>
        </div>
    </div>

@endsection
