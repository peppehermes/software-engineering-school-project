@extends('layouts.layout')

@section('content')
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-payment-inner-st">
                        <ul id="myTabedu1" class="tab-review-design">
                            <li class="active"><a>Publish a new Timetable</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div id="dropzone1" class="pro-ad">
                                                <form action="/timetable/store" method="post"
                                                      id="demo1-upload" enctype="multipart/form-data"
                                                      class="dropzone dropzone-custom needsclick add-professors">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

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

                                                                <label class="control-label">Excel file:</label>

                                                                <input type="file" class="form-control-file"
                                                                       name="timetable">
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-lg-12" style="margin-top: 50px">
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
