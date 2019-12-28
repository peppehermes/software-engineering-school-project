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
                                                <form action="/user/update/{{$userInfo->id}}" method="post"
                                                      class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data" onsubmit="validation()">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label>Name:</label>
                                                                <input name="frm[name]" type="text"
                                                                       class="form-control"
                                                                       value="{{$userInfo->name}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Email:</label>
                                                                <input name="frm[email]" type="email"
                                                                       class="form-control"
                                                                       value="{{$userInfo->email}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Role:</label>
                                                                <select name="frm[roleId]" class="form-control">
                                                                    @foreach($roles as $role)
                                                                        <option
                                                                            @if($userInfo->roleId == $role->id) selected
                                                                            @endif
                                                                            value="{{$role->id}}">{{$role->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Status:</label>
                                                                <select name="frm[status]" class="form-control">
                                                                    <option @if($userInfo->status == 'active')  selected
                                                                            @endif
                                                                            value="active">Enable User
                                                                    </option>
                                                                    <option
                                                                        @if($userInfo->status == 'inactive')  selected
                                                                        @endif
                                                                        value="inactive">Disable User
                                                                    </option>

                                                                </select>
                                                            </div>


                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">


                                                            <div class="form-group">
                                                                <label>Password:</label>
                                                                <input name="password" type="password"
                                                                       class="form-control" id="password"
                                                                       value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Confirm Password:</label>
                                                                <input name="confirmPassword" type="password"
                                                                       class="form-control" id="repassword"
                                                                       value="">
                                                            </div>

                                                            <div class="form-group ">


                                                                <label class="control-label">Photo:</label>

                                                                <input type="file" class="form-control-file"
                                                                       name="photo">


                                                            </div>
                                                            @if(isset($userInfo->photo))
                                                                <div class="form-group ">
                                                                    <img
                                                                        src="{{ asset('/uploads/'.$userInfo->photo) }}"
                                                                        class="img-thumbnail"
                                                                        style="width: 50%;height: 50%"/>
                                                                </div>
                                                            @endif


                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12" style="margin-top: 50px">
                                                            <div class="payment-adress">
                                                                <button
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

