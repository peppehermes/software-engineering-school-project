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
                                                                <label>First Name:</label>
                                                                <input name="frm[firstName]" type="text"
                                                                       class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Last Name:</label>
                                                                <input name="frm[lastName]" type="text"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Place of Birth:</label>
                                                                <input name="frm[birthPlace]" type="text"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group data-custon-pick"
                                                                 id="data_2">
                                                                <label>Date of birth:</label>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i
                                                                            class="fa fa-calendar"></i></span>
                                                                    <input type="text" name="frm[birthday]"
                                                                           class="form-control"
                                                                           id="attendaceDate">
                                                                </div>


                                                            </div>
                                                            <div class="form-group">
                                                                <label>Address:</label>
                                                                <input name="frm[address]" type="text"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Phone:</label>
                                                                <input name="frm[phone]" type="text"
                                                                       class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Post Code:</label>
                                                                <input name="frm[postCode]" id="postcode" type="text"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Fiscal Code:</label>
                                                                <input name="frm[fiscalCode]" type="text"
                                                                       class="form-control">
                                                            </div>



                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                            <div class="form-group">
                                                                <label>Skill:</label>

                                                                <input name="frm[skill]" type="number"
                                                                       class="form-control">

                                                            </div>

                                                            <div class="form-group">
                                                                <label>Email:</label>

                                                                <input name="frm[email]" type="email"
                                                                       class="form-control">

                                                            </div>

                                                            <div class="form-group">
                                                                <label>Gender:</label>
                                                                <select name="frm[gender]" class="form-control">
                                                                    <option value="none" selected="" disabled="">Select
                                                                        Gender
                                                                    </option>
                                                                    <option value="M"
                                                                    >
                                                                        Male
                                                                    </option>
                                                                    <option value="F">
                                                                        Female
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>First Year:</label>
                                                                <select name="frm[firstYear]" class="form-control">
                                                                    <option value="yes" selected>
                                                                        Yes
                                                                    </option>
                                                                    <option value="no">
                                                                        No
                                                                    </option>
                                                                </select>
                                                            </div>


                                                            <div class="form-group">
                                                                <label>Classroom:</label>
                                                                <select name="frm[classId]" class="form-control">
                                                                    <option value="none" selected="" disabled="">Select
                                                                        Classroom
                                                                    </option>
                                                                    @foreach($classrooms as $classroom)
                                                                        <option
                                                                            value="{{$classroom->id}}">{{$classroom->id}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
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


                                                    <div class="row" style="margin-top: 50px">
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
