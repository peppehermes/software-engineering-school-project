@extends('layouts.layout')
@section('content')

    <script>
        Date.prototype.getWeek = function (dowOffset) {
            dowOffset = typeof (dowOffset) == 'int' ? dowOffset : 0; //default dowOffset to zero
            var newYear = new Date(this.getFullYear(), 0, 1);
            var day = newYear.getDay() - dowOffset; //the day of week the year begins on
            day = (day >= 0 ? day : day + 7);
            var daynum = Math.floor((this.getTime() - newYear.getTime() -
                (this.getTimezoneOffset() - newYear.getTimezoneOffset()) * 60000) / 86400000) + 1;
            var weeknum;
            //if the year starts before the middle of a week
            if (day < 4) {
                weeknum = Math.floor((daynum + day - 1) / 7) + 1;
                if (weeknum > 52) {
                    nYear = new Date(this.getFullYear() + 1, 0, 1);
                    nday = nYear.getDay() - dowOffset;
                    nday = nday >= 0 ? nday : nday + 7;
                    /*if the next year starts before the middle of
                      the week, it is week #1 of that year*/
                    weeknum = nday < 4 ? 1 : 53;
                }
            } else {
                weeknum = Math.floor((daynum + day - 1) / 7);
            }
            return weeknum;
        };

        function checkDate() {
            const today = new Date();
            var year = today.getFullYear(),
                week = today.getWeek(),
                w = document.getElementById('week').value,
                y = document.getElementById('week').value;

            // retrieve week and year
            w = w.slice(6, 8);
            y = y.slice(0, 4);

            // set maximum in a month
            week = week + 4;
            // if week is in the next year
            if (week > 52) {
                week = week - 52
                year += 1;
            }
            // holidays
            if (w == 52 || w == 1) {
                alert("This week is out, the school is closed for Christmas");
                location.reload();
            }

            // over the maximum
            else if (w > week && year == y) {
                alert("Please select a week within one month");
                location.reload();
            } else {
                document.getElementById('demo1-upload').action = "/meetings/list";
                document.getElementById('demo1-upload').method = "get";

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
                            <li class="active"><a
                                    href="#description">Professor {{$teach->firstName}} {{$teach->lastName}}</a></li>

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
                                                            <div class="sparkline16-graph">
                                                                <div class="date-picker-inner">

                                                                    <div class="form-group">
                                                                        <label>Select a week:</label>
                                                                        <input type="week" name="frm[week]" id="week"
                                                                               min="2019-W37" max="2020-W28" required>
                                                                    </div>
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
