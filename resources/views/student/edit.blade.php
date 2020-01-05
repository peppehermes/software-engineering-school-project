@extends('layouts.layout')

@section('content')
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-payment-inner-st">
                        <ul id="myTabedu1" class="tab-review-design">
                            <li @if(!Session::get('parent')) class="active" @endif ><a href="#description">Student
                                    Information</a></li>
                            <li @if(Session::get('parent')==1) class="active" @endif><a href="#reviews"> Parent
                                    Information</a></li>
                            {{--                            <li><a href="#INFORMATION">Social Information</a></li>--}}
                        </ul>
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade @if(!Session::get('parent')==1) active in @endif"
                                 id="description">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div id="dropzone1" class="pro-ad">
                                                <form action="/student/update/{{$studentInfo->id}}" method="post"
                                                      class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label>First Name:</label>
                                                                <input name="frm[firstName]" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->firstName}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Last Name:</label>
                                                                <input name="frm[lastName]" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->lastName}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Place of Birth:</label>
                                                                <input name="frm[birthPlace]" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->birthPlace}}">
                                                            </div>
                                                            <div class="form-group data-custon-pick"
                                                                 id="data_2">
                                                                <label>Date of birth:</label>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i
                                                                            class="fa fa-calendar"></i></span>
                                                                    <input type="text" name="frm[birthday]"
                                                                           class="form-control"
                                                                           id="attendaceDate"
                                                                           value="{{$studentInfo->birthday}}">
                                                                </div>


                                                            </div>
                                                            <div class="form-group">
                                                                <label>Address:</label>
                                                                <input name="frm[address]" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->address}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Phone:</label>
                                                                <input name="frm[phone]" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->phone}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Postal Code:</label>
                                                                <input name="frm[postCode]" id="postcode" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->postCode}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Fiscal Code:</label>
                                                                <input name="frm[fiscalCode]" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->fiscalCode}}">
                                                            </div>


                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                            <div class="form-group">
                                                                <label>Skill:</label>

                                                                <input name="frm[skill]" type="number"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->skill}}">

                                                            </div>

                                                            <div class="form-group">
                                                                <label>Email:</label>

                                                                <input name="frm[email]" type="text"
                                                                       class="form-control"
                                                                       value="{{$studentInfo->email}}">

                                                            </div>

                                                            <div class="form-group">
                                                                <label>Gender:</label>
                                                                <select name="frm[gender]" class="form-control">
                                                                    <option value="none" selected="" disabled="">Select
                                                                        Gender
                                                                    </option>
                                                                    <option value="M"
                                                                            @if($studentInfo->gender == 'M') selected @endif>
                                                                        Male
                                                                    </option>
                                                                    <option value="F"
                                                                            @if($studentInfo->gender == 'F') selected @endif>
                                                                        Female
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>First Year:</label>
                                                                <select name="frm[firstYear]" class="form-control">
                                                                    <option value="yes" @if($studentInfo->firstYear == 'yes') selected @endif>
                                                                        Yes
                                                                    </option>
                                                                    <option value="no" @if($studentInfo->firstYear == 'no') selected @endif>
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
                                                                            value="{{$classroom->id}}"
                                                                            @if($studentInfo->classId == $classroom->id) selected @endif>{{$classroom->id}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Description:</label>
                                                                <textarea
                                                                    name="frm[description]">{{$studentInfo->description}}</textarea>
                                                            </div>

                                                            <div class="form-group">


                                                                <label class="control-label">Photo:</label>

                                                                <input type="file" class="form-control-file"
                                                                       name="photo">


                                                            </div>
                                                            <div class="form-group">
                                                                @if(isset($studentInfo->photo))
                                                                    <img
                                                                        src="{{ asset('/uploads/'.$studentInfo->photo) }}"
                                                                        class="img-thumbnail"
                                                                        style="width: 50%;height: 50%"/>
                                                                @endif
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

                            <div class="product-tab-list tab-pane fade @if(Session::get('parent')==1) active in @endif"
                                 id="reviews">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <form action="/student/storeParent/{{$studentInfo->id}}" method="post"
                                                  class="dropzone dropzone-custom needsclick add-parents"
                                                  id="demo1-upload" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Name of Parent 1:</label>
                                                            <input type="text" class="form-control"
                                                                   name="parentName1"
                                                                   @if(isset($studentInfo->parent1)) value="{{$studentInfo->parent1->name}}" @endif >
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email of Parent 1:</label>
                                                            <input type="email" class="form-control"
                                                                   name="parentEmail1"
                                                                   @if(isset($studentInfo->parent1)) value="{{$studentInfo->parent1->email}}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Name of Parent 2:</label>
                                                            <input type="text" class="form-control"
                                                                   name="parentName2"
                                                                   @if(isset($studentInfo->parent2)) value="{{$studentInfo->parent2->name}}" @endif>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email of Parent 2:</label>
                                                            <input type="email" class="form-control"
                                                                   name="parentEmail2"
                                                                   @if(isset($studentInfo->parent2)) value="{{$studentInfo->parent2->email}}" @endif>
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

@endsection
