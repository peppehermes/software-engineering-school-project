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
                                                <form action="/user/store" method="post"
                                                      class="dropzone dropzone-custom needsclick add-professors"
                                                      id="demo1-upload" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group col-md-12">
                                                                <label>Name:</label>
                                                                <input name="frm[name]" type="text"
                                                                       class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Email:</label>
                                                                <input name="frm[email]" id="email" type="email"
                                                                       class="form-control @error('email') is-invalid @enderror"
                                                                       required value="{{ old('email') }}"
                                                                       autocomplete="email">
                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Role:</label>
                                                                <select name="frm[roleId]" class="form-control">
                                                                    <option value="none" selected="" disabled="">Select
                                                                        Role
                                                                    </option>
                                                                    @foreach($roles as $role)
                                                                        <option
                                                                            value="{{$role->id}}">{{$role->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Status:</label>
                                                                <select name="frm[status]" class="form-control">
                                                                    <option selected
                                                                            value="active">Enable User
                                                                    </option>
                                                                    <option
                                                                        value="inactive">Disable User
                                                                    </option>

                                                                </select>
                                                            </div>


                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">


                                                            <div class="form-group col-md-12">
                                                                <label>Password:</label>
                                                                <input name="frm[password]" id="password"
                                                                       type="password"
                                                                       class="form-control @error('password') is-invalid @enderror"
                                                                       autocomplete="new-password"
                                                                       required>

                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label>Confirm Password:</label>
                                                                <input name="confirm_password"
                                                                       id="password-confirm" type="password"
                                                                       class="form-control"
                                                                       required autocomplete="new-password">
                                                            </div>

                                                            <div class="form-group col-md-12">


                                                                <label class="control-label">Photo:</label>

                                                                <input type="file" class="form-control-file"
                                                                       name="photo">


                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="row" >
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
