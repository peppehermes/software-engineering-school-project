@extends('layouts.layout')
@section('content')

    <script>

        function getSubjects() {
            var idClass = document.getElementById("idClass").value,
                subject = document.getElementById("subject"),
                l = subject.length;


            for (var i = 0; i < l; i++) {
                subject.remove(0);

            }

            @foreach($subjects as $subject)
            if ("{{$subject->idClass}}" === idClass) {
                var opt = document.createElement('OPTION');
                opt.text = "{{$subject->subject}} ";
                opt.value = "{{$subject->subject}}";
                subject.appendChild(opt);

            }
            @endforeach
        }


        function checkDate() {


            var extraday, d, m, d1, m1;

            var date = document.getElementById('lecturedate').value;
            var date1 = document.getElementById('deadline').value;
            var str = date.split('/');
            var str1 = date1.split('/');
            d = str[0]; //day of date
            m = str[1]; //month of date
            d1 = str1[0]; //day of deadline
            m1 = str1[1]; // month of deadline


            const today = new Date(),

                dayweek = today.getDay(),
                daymonth = today.getDate(),
                month = today.getMonth() + 1,
                // last day is the monday in the current week
                lastday = daymonth - dayweek + (dayweek == 0 ? -6 : 1);

            // if lastday<0 we are in the previous month, so we have to make a subtraction to establish the correct day
            if (lastday <= 0) {

                // if we are in May,July,October or December the previous months are April,June,September,November,so 30 days
                if (month == 5 || month == 7 || month == 10 || month == 12)
                    extraday = 30 + lastday; // extraday is monday in the current week but in the past month

                // February
                else if (month == 3)
                    extraday = 28 + lastday;
                // All the other months
                else
                    extraday = 31 + lastday;
            }


            if ((lastday <= d && d <= daymonth && m == month) //day between lastday and today
                || (lastday <= 0 && extraday <= d && m == month - 1)//day in previous month greater than or equal extraday
                || (lastday <= 0 && d <= daymonth && m == month))//day in current month lower than or equal today

            {
                //deadline ok if it's in next month and day is lower than day of date or same month but day is greater
                if ((m1 != m && d1 <= d) || (m1 == m && d1 > d)) {

                    document.getElementById('demo1-upload').action = "/assignment/storeassignment";
                    document.getElementById('demo1-upload').method = "post";
                } else {
                    alert("Wrong Deadline!");
                    document.getElementById('dayd').focus();
                    document.getElementById('yeard').focus();
                    document.getElementById('monthd').focus();
                }


            } else {

                alert("Wrong lecture's date!");
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
                            <li class="active"><a href="#description">New Assignment</a></li>
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
                                                      id="demo1-upload" enctype="multipart/form-data"
                                                      onsubmit="checkDate()" name="form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label>Class:</label>
                                                                <select onchange="getSubjects()" name="idClass"
                                                                        id="idClass" class="form-control" required>
                                                                    <option hidden disabled selected></option>

                                                                    @foreach($classes as $class)

                                                                        <option
                                                                            value="{{$class->idClass}}">{{$class->idClass}}</option>


                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Subject:</label>
                                                                <select name="subject" id="subject" class="form-control"
                                                                        required>
                                                                    <option disabled>Select class first</option>
                                                                </select>

                                                            </div>

                                                            <div class="form-group">
                                                                <label>Topic:</label>
                                                                <input name="frm[topic]" type="text"
                                                                       class="form-control" required>
                                                            </div>
                                                        </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">


                                                            <div class="form-group">
                                                                <label>Assignment's Text:</label>
                                                                <input name="frm[text]" type="text"
                                                                       class="form-control" required>
                                                            </div>


                                                            <div class="form-group data-custon-pick"
                                                                 id="data_2">
                                                                <label>Lecture's date:</label>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i
                                                                            class="fa fa-calendar"></i></span>
                                                                    <input type="text" name="lecturedate"
                                                                           class="form-control"
                                                                           id="lecturedate"
                                                                           value="{{$date}}">

                                                                </div>
                                                            </div>


                                                            <div class="form-group data-custon-pick"
                                                                 id="data_2">
                                                                <label>Assignment's Deadline:</label>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i
                                                                            class="fa fa-calendar"></i></span>
                                                                    <input type="text" name="deadline"
                                                                           class="form-control"
                                                                           id="deadline"
                                                                           value="{{$date}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">

                                                                <label class="control-label">Attachment(can attach more than one):</label>
                                                                <input type="file" multiple="multiple"  class="form-control-file"
                                                                       name="attachment[]">


                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12" style="margin-top: 50px">
                                                            <div class="payment-adress">
                                                                <button type="submit"
                                                                        class="btn btn-primary waves-effect waves-light btn-lg center-block">
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
