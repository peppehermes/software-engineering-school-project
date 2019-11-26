<div class="left-sidebar-pro">
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="/"><img class="main-logo" src="/img/logo/logosn.png" alt=""/></a>
            <strong><a href="/"><img src="/img/logo/logosn.png" alt=""/></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    @if(Auth::user()->roleId==3)


                        <li>
                            <a class="has-arrow" href="/student/list" aria-expanded="false"><span
                                    class="educate-icon educate-student icon-wrap"></span> <span class="mini-click-non">Children</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                @foreach ($students as $student)

                                    <li @if(\Request::path()=='student/showmarks/'.$student->id || \Request::path()=='topic/listforparents/'.$student->id || \Request::path()=='material/listforparents/'.$student->id || \Request::path()=='assignment/listforparents/'.$student->id || \Request::path()=='student/attendance_report/'.$student->id) class="active" @endif>
                                        <a class="has-arrow" href="/student/list" aria-expanded="false"><span
                                                class="educate-icon educate-student icon-wrap"></span> <span
                                                class="mini-click-non">{{$student->firstName}}</span></a>
                                        <ul class="submenu-angle" aria-expanded="false">


                                            <li><a title="All Students" href="/student/showmarks/{{$student->id}}"><span
                                                        class="mini-sub-pro"> Marks</span></a></li>

                                            <li><a title="Topics" href="/topic/listforparents/{{$student->id}}"><span
                                                        class="mini-sub-pro">Lectures Topics</span></a>
                                            </li>

                                            <li><a title="Assignments" href="/assignment/listforparents/{{$student->id}}"><span
                                                        class="mini-sub-pro">Lectures Assignments</span></a>
                                            </li>

                                            <li><a title="Material"
                                                   href="/material/listforparents/{{$student->id}}"><span
                                                        class="mini-sub-pro">Support Material</span></a>
                                            </li>
                                            <li><a title="Attendance"
                                                   href="/student/attendance_report/{{$student->id}}"><span
                                                        class="mini-sub-pro">Report Attendance</span></a>
                                            </li>


                                        </ul>

                                    </li>



                                @endforeach

                            </ul>

                        </li>

                    @elseif(Auth::user()->roleId==2)


                        <li><a href="/" aria-expanded="false"><span
                                    class="educate-icon educate-home icon-wrap"></span> <span class="mini-click-non">Home</span></a>
                        </li>

                        <li @if(\Request::path()=='topic/add' || \Request::path()=='topic/list') class="active" @endif>
                            <a class="has-arrow" href="" aria-expanded="false"><span
                                    class="educate-icon educate-form icon-wrap"></span> <span class="mini-click-non">Lecture's Topics</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Add Lecture Topic" href="/topic/add"><span
                                            class="mini-sub-pro">Add Lecture's Topic</span></a></li>
                                <li><a title="Add Lecture Topic" href="/topic/list"><span
                                            class="mini-sub-pro">All Lecture's Topic</span></a></li>
                            </ul>

                        <li @if(\Request::path()=='assignment/add' || \Request::path()=='assignment/list') class="active" @endif>
                            <a class="has-arrow" href="" aria-expanded="false"><span
                                    class="educate-icon educate-event icon-wrap"></span> <span class="mini-click-non">Assignments</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Add Lecture Assignment" href="/assignment/add"><span
                                            class="mini-sub-pro">Add Assignment</span></a></li>
                                <li><a title="View Lecture Assignments" href="/assignment/list"><span
                                            class="mini-sub-pro">All Assignments</span></a></li>
                            </ul>

                        <li @if(\Request::path()=='material/add' || \Request::path()=='material/list') class="active" @endif>
                            <a class="has-arrow" href="" aria-expanded="false"><span
                                    class="educate-icon educate-data-table icon-wrap"></span> <span
                                    class="mini-click-non">Support Material</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Add Support Material" href="/material/add"><span
                                            class="mini-sub-pro">Add Support Material</span></a></li>
                                <li><a title="View Support Material" href="/material/list"><span
                                            class="mini-sub-pro">All Support Material</span></a></li>
                            </ul>


                        <li @if(\Request::path()=='notes/write' || \Request::path()=='notes/list') class="active" @endif>
                            <a class="has-arrow" href="" aria-expanded="false"><span
                                    class="educate-icon educate-message icon-wrap"></span> <span class="mini-click-non">Notes</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Add new Note" href="/notes/write"><span
                                            class="mini-sub-pro">Add new Note</span></a></li>
                                <li><a title="View all Notes" href="/notes/list"><span
                                            class="mini-sub-pro">All Notes</span></a></li>
                            </ul>
                        </li>



                    @else

                        <li @if(\Request::path()=='teacher/list' || \Request::path()=='teacher/add' || \Request::path()=='teacher/edit') class="active" @endif>
                            <a class="has-arrow" href="/teacher/list" aria-expanded="false"><span
                                    class="educate-icon educate-professor icon-wrap"></span> <span
                                    class="mini-click-non">Teachers</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="All Teachers" href="/teacher/list"><span
                                            class="mini-sub-pro">All Teachers</span></a>
                                </li>
                                <li><a title="Add Teacher" href="/teacher/add"><span
                                            class="mini-sub-pro">Add Teacher</span></a>
                                </li>

                            </ul>
                        </li>
                        <li @if(\Request::path()=='student/list' || \Request::path()=='student/add' || \Request::path()=='student/edit') class="active" @endif>
                            <a class="has-arrow" href="/student/list" aria-expanded="false"><span
                                    class="educate-icon educate-student icon-wrap"></span> <span class="mini-click-non">Students</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="All Students" href="/student/list"><span
                                            class="mini-sub-pro">All Students</span></a></li>
                                <li><a title="Add Students" href="/student/add"><span
                                            class="mini-sub-pro">Add Student</span></a></li>

                            </ul>
                        </li>


                        <li @if(\Request::path()=='user/list' || \Request::path()=='user/add' || \Request::path()=='user/edit') class="active" @endif>
                            <a class="has-arrow" href="/user/list" aria-expanded="false"><span
                                    class="educate-icon educate-department icon-wrap"></span> <span
                                    class="mini-click-non">Users</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Departments List" href="/user/list"><span
                                            class="mini-sub-pro">All Users</span></a>
                                </li>
                                <li><a title="Add Departments" href="/user/add"><span
                                            class="mini-sub-pro">Add User</span></a>
                                </li>
                            </ul>
                        </li>

                        <li @if(\Request::path()=='classroom/list' || \Request::path()=='classroom/add' || \Request::path()=='classroom/edit') class="active" @endif>
                            <a class="has-arrow" href="/classroom/list" aria-expanded="false"><span
                                    class="educate-icon educate-form icon-wrap"></span> <span class="mini-click-non">Classrooms</span></a>
                            <ul class="submenu-angle form-mini-nb-dp" aria-expanded="false">
                                <li><a title="Basic Form Elements" href="/classroom/list"><span
                                            class="mini-sub-pro">All Classrooms</span></a></li>
                                <li><a title="Advance Form Elements" href="/classroom/add"><span
                                            class="mini-sub-pro">Add Classroom</span></a></li>

                            </ul>
                        </li>

                    @endif
                </ul>
            </nav>
        </div>
    </nav>
</div>
<!-- End Left menu area -->
