@extends('layouts.layout')

@section('content')

    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @if ($errors->any())
                    <div class="product-payment-inner-st">

                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

{{--    <div class="widgets-programs-area">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel widget-int-shape responsive-mg-b-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="stats-title pull-left">--}}
{{--                                <h4>Page Views</h4>--}}
{{--                            </div>--}}
{{--                            <div class="stats-icon pull-right">--}}
{{--                                <i class="educate-icon educate-apps"></i>--}}
{{--                            </div>--}}
{{--                            <div class="m-t-xl widget-cl-1">--}}
{{--                                <h1 class="text-success">160k+</h1>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and Lorem <strong>typesetting industry</strong> spa.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel widget-int-shape responsive-mg-b-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="stats-title pull-left">--}}
{{--                                <h4>Active Views</h4>--}}
{{--                            </div>--}}
{{--                            <div class="stats-icon pull-right">--}}
{{--                                <i class="educate-icon educate-professor"></i>--}}
{{--                            </div>--}}
{{--                            <div class="m-t-xl widget-cl-2">--}}
{{--                                <h1 class="text-info">462</h1>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and Lorem <strong>typesetting industry</strong> spa.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel widget-int-shape responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="stats-title pull-left">--}}
{{--                                <h4>Earning</h4>--}}
{{--                            </div>--}}
{{--                            <div class="stats-icon pull-right">--}}
{{--                                <i class="educate-icon educate-department"></i>--}}
{{--                            </div>--}}
{{--                            <div class="m-t-xl widget-cl-3">--}}
{{--                                <h1 class="text-warning">$2000</h1>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and Lorem <strong>typesetting industry</strong> spa.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel widget-int-shape res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="stats-title pull-left">--}}
{{--                                <h4>Messages</h4>--}}
{{--                            </div>--}}
{{--                            <div class="stats-icon pull-right">--}}
{{--                                <i class="educate-icon educate-message"></i>--}}
{{--                            </div>--}}
{{--                            <div class="m-t-xl widget-cl-4">--}}
{{--                                <h1 class="text-danger">680</h1>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and Lorem <strong>typesetting industry</strong> spa.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="widget-program-box mg-tb-30">
        <div class="container-fluid">
            <div class="row">
                @if(\Auth::user()->roleId==2)
                @foreach($classRooms as $classroom)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="background-color: #006df0">
                    <div class="hpanel widget-int-shape responsive-mg-b-30">
                        <div class="panel-body">
                            <div class="text-center content-box">
                                <h2 class="m-b-xs">Class {{$classroom->idClass}}</h2>
                                <p class="font-bold text-success">Capacity {{$classroom->capacity}}</p>
                                <div class="m icon-box">
                                    <i class="educate-icon educate-star"></i>
                                </div>
                                <p class="small mg-t-box">
                                    {{$classroom->description}}
                                </p>
                                <a href="/student/attendance/{{$classroom->idClass}}/{{$today}}"> <button class="btn btn-warning widget-btn-3 btn-sm">Submit attendance</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @elseif(\Auth::user()->roleId==3)
                    @foreach($students as $student)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-cards-item">
                            <div class="single-product-image">
                                <a href="#"><img src="img/product/profile-bg.jpg" alt=""></a>
                            </div>
                            <div class="single-product-text">
                                <img src="@if($student->photo) {{ asset('/uploads/'.$student->photo) }} @else @if($student->gender=='F') img/avatar/girl.png @else img/avatar/boy.png  @endif @endif " alt="">
                                <h4><a class="cards-hd-dn" href="#">{{$student->firstName}}</a></h4>
                                <h5>Class {{$student->classId}}</h5>
                                <p class="ctn-cards">Lorem ipsum dolor sit amet, this is a consectetur adipisicing elit</p>
                                <a class="follow-cards" href="/student/showmarks/{{$student->id}}">Marks</a>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="cards-dtn">
{{--                                            <h3><span class="counter">199</span></h3>--}}
                                            <a href="/topic/listforparents/{{$student->id}}"><p>Lectures Topics</p></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="cards-dtn">
{{--                                            <h3><span class="counter">599</span></h3>--}}
                                            <a href="/material/listforparents/{{$student->id}}"><p>Support Material</p></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="cards-dtn">
{{--                                            <h3><span class="counter">399</span></h3>--}}
                                            <a href="/student/attendance_report/{{$student->id}}"><p>Report Attendance</p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
{{--                    @foreach($students as $student)--}}
{{--                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="background-color: #006df0;text-align: center">--}}
{{--                        <div class="hpanel widget-int-shape responsive-mg-b-30">--}}
{{--                            <div class="panel-body">--}}
{{--                                <br class="text-center content-box">--}}
{{--                                    <h2 class="m-b-xs">{{$student->firstName}}</h2>--}}
{{--                                    <p class="font-bold text-success">Class {{$student->classId}}</p>--}}
{{--                                    <div class="m icon-box">--}}
{{--                                        <i class="educate-icon educate-star"></i>--}}
{{--                                    </div>--}}
{{--                                    <p class="small mg-t-box">--}}
{{--                                        fsdfsag--}}
{{--                                        {{$classroom->description}}--}}
{{--                                    </p>--}}

{{--                                <div style="text-align: center;margin-bottom: 10px;">--}}
{{--                                    <a href="/student/showmarks/{{$student->id}}"> <button class="btn btn-warning widget-btn-3 btn-sm">Marks</button></a></br>--}}
{{--                                </div>--}}
{{--                                <div style="text-align: center;margin-bottom: 10px;">--}}
{{--                                    <a href="/student/showmarks/{{$student->id}}"> <button class="btn btn-warning widget-btn-3 btn-sm">Lectures Topics</button></a></br>--}}
{{--                                </div>--}}
{{--                                <div style="text-align: center;margin-bottom: 10px;">--}}
{{--                                    <a href="/student/showmarks/{{$student->id}}"> <button class="btn btn-warning widget-btn-3 btn-sm">Support Material</button></a></br>--}}
{{--                                </div>--}}
{{--                                <div style="text-align: center;margin-bottom: 10px;">--}}
{{--                                    <a href="Report Attendance"> <button class="btn btn-warning widget-btn-3 btn-sm">Report Attendance</button></a></br>--}}
{{--                                </div>--}}



{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @endforeach--}}
                @endif
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel widget-int-shape responsive-mg-b-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="text-center content-box">--}}
{{--                                <h2 class="m-b-xs">Box title</h2>--}}
{{--                                <p class="font-bold text-info">Lorem ipsum</p>--}}
{{--                                <div class="m icon-box">--}}
{{--                                    <i class="educate-icon educate-miscellanous"></i>--}}
{{--                                </div>--}}
{{--                                <p class="small mg-t-box">--}}
{{--                                    Lorem Ipsum passages and more recently with the desktop published software like Aldus PageMaker.--}}
{{--                                </p>--}}
{{--                                <button class="btn btn-info widget-btn-2 btn-sm">Action button</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel widget-int-shape responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="text-center content-box">--}}
{{--                                <h2 class="m-b-xs">Box title</h2>--}}
{{--                                <p class="font-bold text-warning">Lorem ipsum</p>--}}
{{--                                <div class="m icon-box">--}}
{{--                                    <i class="educate-icon educate-interface"></i>--}}
{{--                                </div>--}}
{{--                                <p class="small mg-t-box">--}}
{{--                                    Lorem Ipsum passages and more recently with the desktop published software like Aldus PageMaker.--}}
{{--                                </p>--}}
{{--                                <button class="btn btn-warning widget-btn-3 btn-sm">Action button</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel widget-int-shape res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="text-center content-box">--}}
{{--                                <h2 class="m-b-xs">Box title</h2>--}}
{{--                                <p class="font-bold text-danger">Lorem ipsum</p>--}}
{{--                                <div class="m icon-box">--}}
{{--                                    <i class="educate-icon educate-charts"></i>--}}
{{--                                </div>--}}
{{--                                <p class="small mg-t-box">--}}
{{--                                    Lorem Ipsum passages and more recently with the desktop published software like Aldus PageMaker.--}}
{{--                                </p>--}}
{{--                                <button class="btn btn-danger widget-btn-4 btn-sm">Action button</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
{{--    <div class="widget-program-bg">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner hbggreen bg-1 responsive-mg-b-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="text-center content-bg-pro">--}}
{{--                                <h3>Title text</h3>--}}
{{--                                <p class="text-big font-light">--}}
{{--                                    20--}}
{{--                                </p>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum passages and more recently with desktop published software.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner hbgblue bg-2 responsive-mg-b-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="text-center content-bg-pro">--}}
{{--                                <h3>Title text</h3>--}}
{{--                                <p class="text-big font-light">--}}
{{--                                    160--}}
{{--                                </p>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum passages and more recently with desktop published software.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner hbgyellow bg-3 responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="text-center content-bg-pro">--}}
{{--                                <h3>Title text</h3>--}}
{{--                                <p class="text-big font-light">--}}
{{--                                    750--}}
{{--                                </p>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum passages and more recently with desktop published software.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner hbgred bg-4 res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="text-center content-bg-pro">--}}
{{--                                <h3>Title text</h3>--}}
{{--                                <p class="text-big font-light">--}}
{{--                                    0,43--}}
{{--                                </p>--}}
{{--                                <small>--}}
{{--                                    Lorem Ipsum passages and more recently with desktop published software.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="program-widget-bc mg-t-30 mg-b-15">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner responsive-mg-b-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="table-responsive wd-tb-cr">--}}
{{--                                <table class="table table-striped">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>Task</th>--}}
{{--                                        <th>Date</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-success font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 14, 2013</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-success font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 09, 2015</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-success font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 24, 2014</td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner responsive-mg-b-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="table-responsive wd-tb-cr">--}}
{{--                                <table class="table table-striped">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>Task</th>--}}
{{--                                        <th>Date</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-info font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 14, 2013</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-info font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 09, 2015</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-info font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 24, 2014</td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="table-responsive wd-tb-cr">--}}
{{--                                <table class="table table-striped">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>Task</th>--}}
{{--                                        <th>Date</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-warning font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 14, 2013</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-warning font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 09, 2015</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-warning font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 24, 2014</td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="hpanel shadow-inner res-tablet-mg-t-30 dk-res-t-pro-30">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="table-responsive wd-tb-cr">--}}
{{--                                <table class="table table-striped">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>Task</th>--}}
{{--                                        <th>Date</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-danger font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 14, 2013</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-danger font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 09, 2015</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <span class="text-danger font-bold">Lorem ipsum</span>--}}
{{--                                        </td>--}}
{{--                                        <td>Jul 24, 2014</td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
