@extends('layouts.layout')

@section('content')

    <script>
        function getStudents() {
            var idClass = document.getElementById("idClass").value;
            var students = document.getElementById("idStudent");
            var subject = document.getElementById("subject");
            var l=subject.length;
            var l1=students.length;
            //delete students from a pre-selected class, if any
            var i = 0;

            for (i = 0; i < l1; i++) {
                students.remove(0);
            }
            for ( i = 0; i <l; i++) {
                subject.remove(0);
            }

            //append option to the student select box, showing only students of the selected class

            @foreach($stud as $student)
                if ("{{$student->classId}}" === idClass) {
                    var opt = document.createElement('OPTION');
                    opt.text = "{{$student->firstName}} {{$student->lastName}}";
                    opt.value = "{{$student->id}}";
                    students.appendChild(opt);
                }
            @endforeach


                @foreach($subjects as $subject)
            if ("{{$subject->idClass}}" === idClass) {
                var opt1 = document.createElement('OPTION');
                opt1.text = "{{$subject->subject}} ";
                opt1.value = "{{$subject->subject}}";
                subject.appendChild(opt1);
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
                        </ul>
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div id="dropzone1" class="pro-ad">
                                                <form action="/notes/store" method="post"
                                                      id="demo1-upload" enctype="multipart/form-data" name="form"
                                                      class="dropzone dropzone-custom needsclick add-professors">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group" id="class">
                                                                <label>Class</label>
                                                                <select onchange="getStudents()" id="idClass" name="idClass" class="form-control" required>
                                                                    <option hidden disabled selected></option>
                                                                        @foreach($classes as $class)
                                                                        <option value="{{$class->idClass}}">{{$class->idClass}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group" id="class">
                                                                <label>Student</label>
                                                                <select id="idStudent" name="idStudent" class="form-control" required>
                                                                    <option disabled>Select class first</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label>Subject:</label>
                                                                <select name="subject" id="subject" class="form-control" required>
                                                                    <option disabled>Select class first</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group" id="topic">
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
                                                                        class="btn btn-primary waves-effect waves-light btn-lg center-block" >
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
