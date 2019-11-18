@extends('layouts.layout')

@section('content')
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
                                                <form action="/teacher/store" method="post"
                                                      class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group col-md-6">
                                                                <label>First Name:</label>
                                                                <input name="frm[firstName]" type="text"
                                                                       class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Last Name:</label>
                                                                <input name="frm[lastName]" type="text"
                                                                       class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Place of Birth:</label>
                                                                <input name="frm[birthPlace]" type="text"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group col-lg-3">
                                                                <label class="form-group">Date of birth:</label>
                                                            </div>
                                                            <div class="form-group col-lg-3">

                                                                <select name="year" class="form-control" required>
                                                                    <option value="none" disabled="" selected>
                                                                        Year
                                                                    </option>
                                                                    @for($i=1960 ;  $i<1998 ; $i++)
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-lg-3">


                                                                <select name="month" class="form-control" required>
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

                                                                <select name="day" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Day
                                                                    </option>
                                                                    @for($j=1 ;  $j<31 ; $j++)
                                                                        <option value="{{$j}}">{{$j}}</option>
                                                                    @endfor
                                                                </select>

                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label>Address:</label>
                                                                <input name="frm[address]" type="text"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Phone:</label>
                                                                <input name="frm[phone]" type="number"
                                                                       class="form-control" >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Postal Code:</label>
                                                                <input name="frm[postCode]" id="postcode" type="text"
                                                                       class="form-control" >
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Email:</label>
                                                                <input name="email" type="text"
                                                                       class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Fiscal code:</label>
                                                                <input name="frm[fiscalCode]" type="text"
                                                                       class="form-control">
                                                            </div>


                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Class:</label>
                                                            <select name="frmT[idClass]" class="form-control" required>

                                                                @foreach($classes as $class)
                                                                    <option value="{{$class->id}}">{{$class->id}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Subject:</label>
                                                            <input name="frmT[subject]" type="text"
                                                                   class="form-control">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



                                                            <div class="form-group">
                                                                <label>Gender:</label>
                                                                <select name="frm[gender]" class="form-control">
                                                                    <option value="none" selected="" disabled="">Select
                                                                        Gender
                                                                    </option>
                                                                    <option value="M">
                                                                        Male
                                                                    </option>
                                                                    <option value="F">
                                                                        Female
                                                                    </option>
                                                                </select>
                                                            </div>



                                                            <div class="form-group res-mg-t-15">
                                                                <label>Description:</label>
                                                                <textarea name="frm[description]"></textarea>
                                                            </div>

                                                            <div class="form-group">


                                                                <label class="control-label">Photo:</label>

                                                                <input type="file" class="form-control-file"
                                                                       name="photo">


                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="payment-adress">
                                                                <button type="submit"
                                                                        class="btn btn-primary btn-lg center-block">
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
