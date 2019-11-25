@extends('layouts.layout')

@section('content')

    <script>
        function getStudents() {
            var idClass = document.getElementById("idClass").value;
            var students = document.getElementById("idStudent");

            //delete students from a pre-selected class, if any
            var i = 0;
            for (i = 0; i < students.length; i++) {
                students.remove(i);
            }

            //append option to the student select box, showing only students of the selected class
            var opt = document.createElement('OPTION');
            @foreach($stud as $student)
                if ("{{$student->classId}}" === idClass) {
                    opt.text = "{{$student->firstName}} {{$student->lastName}}";
                    opt.value = "{{$student->id}}";
                    students.appendChild(opt);
                }
            @endforeach
        }
    </script>

        <!-- Single pro tab review Start-->
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-payment-inner-st">
                        <ul id="myTabedu1" class="tab-review-design">
                            <li class="active"><a href="#description">Insert new Note</a></li>
                            {{--                            <li><a href="#reviews"> Account Information</a></li>--}}
                            {{--                            <li><a href="#INFORMATION">Social Information</a></li>--}}
                        </ul>
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div id="dropzone1" class="pro-ad">
                                                <form action="/notes/store" method="post" class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data" name="form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
                                                            <div class="form-group col-md-4" id="class">
                                                                <label>Class</label>
                                                                <select onchange="getStudents()" id="idClass" name="idClass" class="form-control" required>
                                                                    <option hidden disabled selected></option>
                                                                        @foreach($classes as $class)
                                                                        <option value="{{$class->idClass}}">{{$class->idClass}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-4" id="class">
                                                                <label>Student</label>
                                                                <select id="idStudent" name="idStudent" class="form-control" required>
                                                                    <option disabled>Select class first</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-4" id="subject">
                                                                <label class="login2">Subject</label>
                                                                <input name="frm[subject]" type="text"
                                                                       class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-md-12" id="topic">
                                                                <label>Note</label>
                                                                <textarea name="frm[note]" type="text"
                                                                       class="form-control" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 50px">
                                                        <div class="col-lg-12">
                                                            <div class="payment-adress">
                                                                <button type="submit"
                                                                        class="btn btn-primary waves-effect waves-light">
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
    </div>

@endsection
