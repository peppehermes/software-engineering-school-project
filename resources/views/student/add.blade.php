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
                                                <form action="/student/store" method="post"
                                                      class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <input name="frm[firstName]" type="text"
                                                                       class="form-control" required
                                                                       placeholder="First Name">
                                                            </div>
                                                            <div class="form-group">
                                                                <input name="frm[lastName]" type="text"
                                                                       class="form-control" required
                                                                       placeholder="Last Name">
                                                            </div>
                                                            <div class="form-group">
                                                                <input name="frm[address]" type="text"
                                                                       class="form-control"
                                                                       placeholder="Address">
                                                            </div>
                                                            <div class="form-group">
                                                                <input name="frm[phone]" type="number"
                                                                       class="form-control" placeholder="Phone no.">
                                                            </div>
                                                            <div class="form-group">
                                                                <input name="frm[postCode]" id="postcode" type="text"
                                                                       class="form-control" placeholder="Postcode">
                                                            </div>
                                                            <div class="form-group">
                                                                <input name="frm[P1firstName]" type="text"
                                                                       class="form-control" required
                                                                       placeholder="Parent 1 First Name">
                                                            </div>
                                                            <div class="form-group col-lg-3">
                                                                <label class="form-group">Date of birth:</label>
                                                            </div>
                                                            <div class="form-group col-lg-3">

                                                                <select name="year" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Year
                                                                    </option>
                                                                    @for($i=2000 ;  $i<2019 ; $i++)
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-lg-3">


                                                                <select name="month" class="form-control" required>
                                                                    <option value="none" selected="" disabled="">
                                                                        Month
                                                                    </option>
                                                                    <option value="1">January</option>
                                                                    <option value="2">February</option>
                                                                    <option value="3">March</option>
                                                                    <option value="4">April</option>
                                                                    <option value="5">May</option>
                                                                    <option value="6">June</option>
                                                                    <option value="7">July</option>
                                                                    <option value="8">August</option>
                                                                    <option value="9">September</option>
                                                                    <option value="10">October</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">December</option>
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

                                                            <div class="form-group">


                                                                <label class="control-label">Photo:</label>

                                                                <input type="file" class="form-control-file"
                                                                       name="photo">

                                                            </div>

                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                            <div class="form-group">
                                                                <input name="frm[email]" type="text"
                                                                       class="form-control"
                                                                       placeholder="Email">
                                                            </div>
                                                            <div class="form-group">
                                                                <select name="frm[gender]" class="form-control">
                                                                    <option value="none" selected="" disabled="">Select
                                                                        Gender
                                                                    </option>
                                                                    <option value="M">Male</option>
                                                                    <option value="F">Female</option>
                                                                </select>
                                                            </div>


                                                            <div class="form-group">
                                                                <select name="frm[classId]" class="form-control">
                                                                    <option value="none" selected="" disabled="">Select
                                                                        Class
                                                                    </option>
                                                                    @foreach($classrooms as $classroom)
                                                                        <option
                                                                            value="{{$classroom->id}}">{{$classroom->id}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group res-mg-t-15">
                                                                <textarea name="frm[description]"
                                                                          placeholder="Description"></textarea>
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
                            {{--                            <div class="product-tab-list tab-pane fade" id="reviews">--}}
                            {{--                                <div class="row">--}}
                            {{--                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                            {{--                                        <div class="review-content-section">--}}
                            {{--                                            <div class="row">--}}
                            {{--                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                            {{--                                                    <div class="devit-card-custom">--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="text" class="form-control" placeholder="Email">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="number" class="form-control"--}}
                            {{--                                                                   placeholder="Phone">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="password" class="form-control"--}}
                            {{--                                                                   placeholder="Password">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="password" class="form-control"--}}
                            {{--                                                                   placeholder="Confirm Password">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <a href="#!" class="btn btn-primary waves-effect waves-light">Submit</a>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="product-tab-list tab-pane fade" id="INFORMATION">--}}
                            {{--                                <div class="row">--}}
                            {{--                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                            {{--                                        <div class="review-content-section">--}}
                            {{--                                            <div class="row">--}}
                            {{--                                                <div class="col-lg-12">--}}
                            {{--                                                    <div class="devit-card-custom">--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="url" class="form-control"--}}
                            {{--                                                                   placeholder="Facebook URL">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="url" class="form-control"--}}
                            {{--                                                                   placeholder="Twitter URL">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="url" class="form-control"--}}
                            {{--                                                                   placeholder="Google Plus">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="form-group">--}}
                            {{--                                                            <input type="url" class="form-control"--}}
                            {{--                                                                   placeholder="Linkedin URL">--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <button type="submit"--}}
                            {{--                                                                class="btn btn-primary waves-effect waves-light">Submit--}}
                            {{--                                                        </button>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
