<!-- Start Welcome area -->
<div class="all-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="logo-pro">
                    <a href="/home"><img class="main-logo" src="{{ asset('/img/logo/logosn.png')}}" alt=""/></a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-advance-area">
        <div class="header-top-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="header-top-wraper">
                            <div class="row">
                                <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                    <div class="menu-switcher-pro">
                                        <button type="button" id="sidebarCollapse"
                                                class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                            <i class="educate-icon educate-nav"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                        <ul class="nav navbar-nav mai-top-nav">

                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="header-right-info">
                                        <ul class="nav navbar-nav mai-top-nav header-right-menu">

                                            <li class="nav-item">
                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                                   class="nav-link dropdown-toggle">
                                                    @if(isset(Auth::user()->photo))<img
                                                        src="{{ asset('/uploads/'.Auth::user()->photo) }}" alt=""/>
                                                    @endif
                                                    <span class="admin-name">{{Auth::user()->name}}</span>
                                                    <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                                </a>
                                                <ul role="menu"
                                                    class="dropdown-header-top author-log dropdown-menu animated fadeInDown">

                                                    <li><a href="/user/edit/{{Auth::user()->id}}"><span
                                                                class="edu-icon edu-user-rounded author-log-ic"></span>My
                                                            Profile</a>
                                                    </li>

                                                    <li><a href="{{ route('logout') }}"
                                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span
                                                                class="edu-icon edu-locked author-log-ic"></span> {{ __('Logout') }}
                                                        </a>
                                                    </li>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                          style="display: none;">
                                                        @csrf
                                                    </form>
                                                </ul>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu start -->
        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul class="mobile-menu-nav">

                                    @if(Auth::user()->roleId==\App\User::roleTeacher || Auth::user()->roleId==\App\User::roleClasscoordinator)
                                        <li><a href="/">Home</a></li>
                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Lecture's Topics<span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/topic/add">Add Lectures Topic</a>
                                                </li>
                                                <li><a href="/topic/list">All Lectures Topics</a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Marks<span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/mark/add">Add Mark</a>
                                                </li>
                                                <li><a href="/mark/list">All Marks</a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Assignments<span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/assignment/add">Add Assignment</a>
                                                </li>
                                                <li><a href="/assignment/list">All Assignments</a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Support Material<span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/material/add">Add Support Material</a>
                                                </li>
                                                <li><a href="/material/list">All Support Material</a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Notes<span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/notes/add">Add Note</a>
                                                </li>
                                                <li><a href="/notes/list">All Notes</a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Meetings<span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/meetings/addweek">All Meetings</a>
                                                </li>
                                                <li><a href="/meetings/add">Provide Timeslots</a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li><a data-target="#demoevent" href="/timetable/list">Timetables</a></li>

                                        @if (Auth::user()->roleId==\App\User::roleClasscoordinator)
                                            <li @if(\Request::path()=='finalgrades/insert') class="active" @endif>
                                                <a href="/finalgrades/insert">Final Grades</a>
                                            </li>
                                        @endif

                                    @elseif(Auth::user()->roleId==\App\User::rolePrincipal)

                                        <li><a href="/">Home</a></li>
                                        <li><a href="/classroom/balanced">Classrooms</a></li>

                                    @elseif(Auth::user()->roleId==\App\User::roleParent)
                                        <li><a data-toggle="collapse" href="/"><span class="mini-click-non">Home</span></a>
                                        </li>
                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Children <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>

                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                @foreach ($students as $student)
                                                    <li><a href="/student/list">{{$student->firstName}}</a>
                                                        <ul id="demoevent" class="collapse dropdown-header-top">
                                                            <li><a href="/student/showmarks/{{$student->id}}">
                                                                    Marks</a>
                                                            </li>
                                                            <li><a href="/topic/listforparents/{{$student->id}}">
                                                                    Lectures Topics</a>
                                                            </li>
                                                            <li><a href="/assignment/listforparents/{{$student->id}}">
                                                                    Assignments</a>
                                                            </li>
                                                            <li><a href="/material/listforparents/{{$student->id}}">
                                                                    Support Material</a>
                                                            </li>
                                                            <li><a href="/student/attendance_report/{{$student->id}}">
                                                                    Report Attendance</a>
                                                            </li>
                                                            <li><a href="/notes/shownotes/{{$student->id}}">
                                                                    Notes</a>
                                                            </li>

                                                            <li><a href="/timetable/listforparents/{{$student->id}}">
                                                                    Timetable</a>
                                                            </li>

                                                            <li @if(\Request::path()=='meetings/choose/{{$student->id}}') class="active" @endif>
                                                                <a
                                                                    href="/meetings/choose/{{$student->id}}">
                                                                    Book Meeting</a>
                                                            </li>

                                                            <li><a href="/finalgrades/listforparents/{{$student->id}}">
                                                                    Final Grades</a>
                                                            </li>


                                                        </ul>
                                                    </li>

                                                @endforeach
                                            </ul>

                                        </li>

                                        <li><a data-toggle="collapse" data-target="#demoevent" href="/communications/list">Communications <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        </li>

                                        <li><a data-toggle="collapse" data-target="#demoevent" href="/meetings/listforparents">Your Meetings <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        </li>

                                    @else
                                        <li><a data-toggle="collapse" href="/"><span class="mini-click-non">Home</span></a>
                                        </li>
                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Teachers <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/teacher/list">All Teachers</a>
                                                </li>
                                                <li><a href="/teacher/add">Add Teacher</a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li><a data-toggle="collapse" data-target="#demopro" href="#">Students <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demopro" class="collapse dropdown-header-top">
                                                <li><a href="/student/list">All Students</a>
                                                </li>
                                                <li><a href="/student/add">Add Student</a>
                                                </li>

                                            </ul>
                                        </li>


                                        <li><a data-toggle="collapse" data-target="#demopro" href="#">Classrooms <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demopro" class="collapse dropdown-header-top">
                                                <li><a href="/classroom/list">All Classrooms</a>
                                                </li>
                                                <li><a href="/classroom/add">Add Classroom</a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Timetables<span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/timetable/list">All Timetables</a>
                                                </li>
                                                <li><a href="/timetable/add">Upload Timetable</a>
                                                </li>
                                                <li><a href="/timetable/chooseclass">Add Manually</a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li><a data-toggle="collapse" data-target="#demoevent" href="#">Communications <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demoevent" class="collapse dropdown-header-top">
                                                <li><a href="/communications/list">Board</a>
                                                </li>
                                                <li><a href="/communications/add">Add Communications</a>
                                                </li>

                                            </ul>
                                        </li>

                                    @endif

                                    @if(Auth::user()->roleId==\App\User::roleSuperadmin)
                                        <li><a data-toggle="collapse" data-target="#demopro" href="#">Users <span
                                                    class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="demopro" class="collapse dropdown-header-top">
                                                <li><a href="/user/list">All Users</a>
                                                </li>
                                                <li><a href="/user/add">Add User</a>
                                                </li>

                                            </ul>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu end -->
    </div>

