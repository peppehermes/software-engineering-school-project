@extends('layouts.layout')

@section('content')
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-payment-inner-st">
                        <ul id="myTabedu1" class="tab-review-design">
                            <li class="active"><a href="#description">Publish a new Timetable</a></li>
                            {{--                            <li><a href="#reviews"> Account Information</a></li>--}}
                            {{--                            <li><a href="#INFORMATION">Social Information</a></li>--}}
                        </ul>
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div id="dropzone1" class="pro-ad">
                                                <form action="/timetable/store" method="post"
                                                      class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                            <div class="form-group col-lg-12">
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

                                                            <div class="form-group col-lg-12">

                                                                <label class="control-label">Excel file:</label>

                                                                <input type="file" class="form-control-file"
                                                                       name="timetable">
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
