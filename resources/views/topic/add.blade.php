@extends('layouts.layout')

@section('content')
    <script>
        function checkDate() {
            var d, m, y;

            d = document.getElementById('day').value;
            m = document.getElementById('month').value;
            y = document.getElementById('year').value;

            var today = new Date();
            var day_of_week = today.getDay() - 1;
            var dt = new Date(year = y, month = m-1, day = today.getDate() - day_of_week);



            if (y == today.getFullYear() &&
                (m == today.getMonth() + 1 || m == today.getMonth()) &&
                (dt.getDate() <= d && d <= today.getDate())) {
                document.getElementById('demo1-upload').action = "/topic/storetopic";
                document.getElementById('demo1-upload').method = "post";
            }
            else {
                alert("Wrong date!");
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
                            <li class="active"><a href="#description">Basic Information</a></li>
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
                                                                <select name="idClass" class="form-control" required>

                                                                        @foreach($classes as $class)
                                                                        <option value="{{$class->idClass}}">{{$class->idClass}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Subject:</label>
                                                                <input name="frm[subject]" type="text"
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
                                                                    @for($i=2019 ;  $i<2021 ; $i++)
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-lg-3">


                                                                <select id="month" name="month" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Month
                                                                    </option>
                                                                    <option value="1">
                                                                        January
                                                                    </option>
                                                                    <option value="2">
                                                                        February
                                                                    </option>
                                                                    <option value="3">
                                                                        March
                                                                    </option>
                                                                    <option value="4">
                                                                        April
                                                                    </option>
                                                                    <option value="5">
                                                                        May
                                                                    </option>
                                                                    <option value="6">
                                                                        June
                                                                    </option>
                                                                    <option value="7">
                                                                        July
                                                                    </option>
                                                                    <option value="8">
                                                                        August
                                                                    </option>
                                                                    <option value="9">
                                                                        September
                                                                    </option>
                                                                    <option value="10">
                                                                        October
                                                                    </option>
                                                                    <option value="11">
                                                                        November
                                                                    </option>
                                                                    <option value="12">
                                                                        December
                                                                    </option>
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

                                                            <div class="form-group col-md-12">
                                                                <label>Topic:</label>
                                                                <input name="frm[topic]" type="text"
                                                                       class="form-control">
                                                            </div>


                                                        </div>


                                                    </div>
                                                    <div class="row">
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
