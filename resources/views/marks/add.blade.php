@extends('layouts.layout')
@section('content')

    <script>

       function markvalue() {

           var selector = document.getElementById("range"),
               mark = document.getElementById("mark");

           mark.value=selector.value;
       }

        function getStudentsandSubjects() {
            var idClass = document.getElementById("idClass").value,
                student = document.getElementById("idStudent"),
                subject = document.getElementById("subject"),
                l=subject.length,
                l1=student.length;


            for (var i = 0; i < l1; i++) {
                student.remove(0);
            }

            for ( i = 0; i < l; i++) {
                subject.remove(0);
            }

            @foreach($studId as $stud)
            if ("{{$stud->classId}}" === idClass) {
                var opt = document.createElement('OPTION');
                opt.text = "{{$stud->firstName}} {{$stud->lastName}}";
                opt.value = "{{$stud->id}}";
                student.appendChild(opt);
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


        function checkDate() {

            var  extraday,d,m;

            d  = document.getElementById('day').value;
            m  = document.getElementById('month').value;




            const today = new Date(),
                dayweek=today.getDay(),
                daymonth=today.getDate(),
                month=today.getMonth()+1,
                lastday= daymonth - dayweek + (dayweek == 0 ? -6:1);

            if(lastday<=0){

                if(month == 5 || month == 7 || month == 10 || month == 12)
                    extraday=30+lastday;

                else if(month==3)
                    extraday=28+lastday;

                else
                    extraday=31+lastday;

            }

            if((lastday <= d && d <= daymonth && m==month)
                ||(lastday <= 0 && extraday <= d  && m==month-1)
                || (lastday <= 0 && d <= daymonth && m==month))
            {

                    document.getElementById('demo1-upload').action = "/mark/storemark";
                    document.getElementById('demo1-upload').method = "post";


            }

            else {
                alert("Wrong  date!");
                document.getElementById('day').focus();
                document.getElementById('year').focus();
                document.getElementById('month').focus();
            }

        }


    </script>


    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-payment-inner-st">
                        <ul id="myTabedu1" class="tab-review-design">
                            <li class="active"><a href="#description">New Grade</a></li>
                            {{--                            <li><a href="#reviews"> Account Information</a></li>--}}
                            {{--                            <li><a href="#INFORMATION">Social Information</a></li>--}}
                        </ul>
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div id="dropzone1" class="pro-ad">
                                                <form class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data" onsubmit="checkDate()" name="form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group col-md-6">

                                                                <label>Class:</label>
                                                                <select onchange="getStudentsandSubjects()" name="idClass" id="idClass" class="form-control" required>
                                                                    <option hidden disabled selected></option>
                                                                    @foreach($classes as $class)
                                                                        <option value="{{$class->idClass}}">{{$class->idClass}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>


                                                            <div class="form-group col-md-5">
                                                                <label>Grade:</label>
                                                                <select id="mark" name="mark" type="float" class="form-control" required>

                                                                    <option value="1">1</option>
                                                                    <option value="1.25">1+</option>
                                                                    <option value="1.5">1.5</option>
                                                                    <option value="1.75">2-</option>
                                                                    <option value="2">2</option>
                                                                    <option value="2.25">2+</option>
                                                                    <option value="2.5">2.5</option>
                                                                    <option value="2.75">3-</option>
                                                                    <option value="3">3</option>
                                                                    <option value="3.25">3+</option>
                                                                    <option value="3.5">3.5</option>
                                                                    <option value="3.75">4-</option>
                                                                    <option value="4">4</option>
                                                                    <option value="4.25">4+</option>
                                                                    <option value="4.5">4.5</option>
                                                                    <option value="4.75">5-</option>
                                                                    <option value="5">5</option>
                                                                    <option value="5.25">5+</option>
                                                                    <option value="5.5">5.5</option>
                                                                    <option selected value="5.75">6-</option>
                                                                    <option value="6">6</option>
                                                                    <option value="6.25">6+</option>
                                                                    <option value="6.5">6.5</option>
                                                                    <option value="6.75">7-</option>
                                                                    <option value="7">7</option>
                                                                    <option value="7.25">7+</option>
                                                                    <option value="7.5">7.5</option>
                                                                    <option value="7.75">8-</option>
                                                                    <option value="8">8</option>
                                                                    <option value="8.25">8+</option>
                                                                    <option value="8.5">8.5</option>
                                                                    <option value="8.75">9-</option>
                                                                    <option value="9">9</option>
                                                                    <option value="9.25">9+</option>
                                                                    <option value="9.5">9.5</option>
                                                                    <option value="9.75">10-</option>
                                                                    <option value="10">10</option>
                                                                    <option value="10.25">10 cum laude</option>

                                                                </select>

                                                                    <input  type="range" id="range" min="1" max="10.25" step="0.25" onclick="markvalue()"  aria-label="select pen size">

                                                            </div>


                                                            <div class="form-group col-md-6">
                                                                <label>Student:</label>
                                                                <select name="idStudent" id="idStudent" class="form-control" required>
                                                                    <option disabled>Select class first</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Subject:</label>
                                                                <select name="subject" id="subject" class="form-control" required>
                                                                    <option disabled>Select class first</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-10">
                                                                <label>Topic:</label>
                                                                <input name="frm[topic]" type="text"
                                                                       class="form-control" required>
                                                            </div>

                                                            <div class="form-group col-lg-3">
                                                                <label class="form-group">Lecture's Date:</label>
                                                            </div>
                                                            <div class="form-group col-lg-3">

                                                                <select id="year" name="year" class="form-control" required>
                                                                    <option value="none"  selected="" disabled="">
                                                                        Year
                                                                    </option>
                                                                    <option value="{{date("Y")}}">{{date("Y")}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-lg-3">


                                                                <select id="month" name="month" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Month
                                                                    </option>
                                                                    <option value="<?php $date = new DateTime("last month"); echo $date->format('m');?>">
                                                                        <?php $date = new DateTime("last month"); echo $date->format('F');?></option>

                                                                    <option value="{{date("m")}}">{{date("F")}}</option>
                                                                </select>

                                                            </div>
                                                            <div class="form-group col-lg-3">

                                                                <select id="day" name="day" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Day
                                                                    </option>
                                                                    @for($j=1 ;  $j<32 ; $j++)
                                                                        <option value="{{$j}}">{{$j}}</option>
                                                                    @endfor
                                                                </select>

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
