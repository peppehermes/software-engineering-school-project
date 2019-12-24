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


    <div class="widget-program-box mg-tb-30">
        <div class="container-fluid">
            <div class="row">
                @if(\Auth::user()->roleId==\App\User::roleTeacher || \Auth::user()->roleId==\App\User::roleClasscoordinator)
                    @foreach($classRooms as $classroom)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="background-color: #006df0;margin-right: 50px">
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
                                        <a href="/student/attendance/{{$classroom->idClass}}/{{$today}}">
                                            <button class="btn btn-warning widget-btn-3 btn-sm">Submit attendance
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @elseif(\Auth::user()->roleId==\App\User::roleParent)
                    @foreach($students as $student)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="single-cards-item">
                                <div class="single-product-image">
                                    <a href="#"><img src="img/product/profile-bg.jpg" alt=""></a>
                                </div>
                                <div class="single-product-text">
                                    <img
                                        src="   @if($student->photo) {{ asset('/uploads/'.$student->photo) }}
                                                @else
                                                    @if($student->gender=='F') img/avatar/girl.png
                                                    @else img/avatar/boy.png
                                                    @endif
                                                @endif "
                                        alt="">
                                    <h4><a class="cards-hd-dn" href="#">{{$student->firstName}}</a></h4>
                                    <h5>Class {{$student->classId}}</h5>
                                    <p class="ctn-cards">Lorem ipsum dolor sit amet, this is a consectetur adipisicing
                                        elit</p>
                                    <a class="follow-cards" href="/student/showmarks/{{$student->id}}">Marks</a>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="cards-dtn">
                                                {{--                                            <h3><span class="counter">199</span></h3>--}}
                                                <a href="/topic/listforparents/{{$student->id}}"><p>Lectures Topics</p>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="cards-dtn">
                                                {{--                                            <h3><span class="counter">599</span></h3>--}}
                                                <a href="/material/listforparents/{{$student->id}}"><p>Support
                                                        Material</p></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="cards-dtn">
                                                {{--                                            <h3><span class="counter">399</span></h3>--}}
                                                <a href="/student/attendance_report/{{$student->id}}"><p>Report
                                                        Attendance</p></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="cards-dtn">
                                                {{--                                            <h3><span class="counter">199</span></h3>--}}
                                                <a href="/assignment/listforparents/{{$student->id}}"><p>Assignments</p>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="cards-dtn">
                                                {{--                                            <h3><span class="counter">599</span></h3>--}}
                                                <a href="/timetable/listforparents/{{$student->id}}"><p>Timetable</p></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="cards-dtn">
                                                {{--                                            <h3><span class="counter">399</span></h3>--}}
                                                <a href="/notes/shownotes/{{$student->id}}"><p>Notes</p></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @endif

            </div>
        </div>
    </div>

@endsection
