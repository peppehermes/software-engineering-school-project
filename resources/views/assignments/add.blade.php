@extends('layouts.layout')
@section('content')

    <script>


function checkDate() {

   var  extraday,d,m,d1,m1;

    d  = document.getElementById('day').value;
    m  = document.getElementById('month').value;
    d1 = document.getElementById('dayd').value;
    m1 = document.getElementById('monthd').value;



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
           if((m1 != m && d1 <= d) || (m1 == m && d1 > d)) {
               document.getElementById('demo1-upload').action = "/assignment/storeassignment";
               document.getElementById('demo1-upload').method = "post";
           }

           else {
               alert("Wrong Deadline!"+d1+d+m1+m);
               document.getElementById('dayd').focus();
               document.getElementById('yeard').focus();
               document.getElementById('monthd').focus();
           }

       }
        else {
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


                                                            <div class="form-group col-md-10">
                                                                <label>Assignment's Text:</label>
                                                                <input name="frm[text]" type="text"
                                                                       class="form-control" required>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Subject:</label>
                                                                <select name="subject" class="form-control" required>
                                                                @foreach($classes as $class)
                                                                    <option value="{{$class->subject}}">{{$class->subject}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6">
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

                                                            <div class="form-group col-lg-3">
                                                                <label class="form-group">Assignment's Deadline:</label>
                                                            </div>
                                                            <div class="form-group col-lg-3">

                                                                <select id="yeard" name="yeard" class="form-control" required>
                                                                    <option value="none"  selected="" disabled="">
                                                                        Year
                                                                    </option>
                                                                    <option value="{{date("Y")}}">{{date("Y")}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-lg-3">


                                                                <select id="monthd" name="monthd" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Month
                                                                    </option>

                                                                    <option value="{{date("m")}}">{{date("F")}}</option>

                                                                    <option value="<?php $date = new DateTime("next month"); echo $date->format('m');?>">
                                                                        <?php $date = new DateTime("next month"); echo $date->format('F');?></option>


                                                                </select>

                                                            </div>
                                                            <div class="form-group col-lg-3">

                                                                <select id="dayd" name="dayd" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Day
                                                                    </option>
                                                                    @for($j=1 ;  $j<32 ; $j++)
                                                                        <option value="{{$j}}">{{$j}}</option>
                                                                    @endfor
                                                                </select>

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
