@extends('layouts.layout')

@section('content')

    <div class="breadcome-area">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="add-product">
                            <a href="/teacher/add">Add a new teacher</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contacts-area mg-b-15">
        <div class="container-fluid">

            @foreach($teachers as $key=>$teacher)
                @if($key==0 || $key%4==0)
                    <div class="row">
                        @endif
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="hpanel hblue contact-panel contact-panel-cs responsive-mg-b-30">
                                <div class="panel-body custom-panel-jw">

                                    <img alt="logo" class="img-circle m-b"
                                         src="@if(isset($teacher->photo)){{ asset('/uploads/'.$teacher->photo) }} @else {{ asset('/img/contact/4.jpg') }} @endif">
                                    <h3><a href="/teacher/edit/{{$teacher->id}}">John Alva</a></h3>
                                    <p class="all-pro-ad">London, LA</p>
                                    <p>
                                        Lorem ipsum dolor sit amet of, consectetur adipiscing elitable. Vestibulum
                                        tincidunt est vitae ultrices accumsan.
                                    </p>
                                    <a href="/teacher/edit/{{$teacher->id}}">
                                        <button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    </a>
                                    <a href="/teacher/delete/{{$teacher->id}}">
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </a>
                                </div>

                            </div>
                        </div>
                        @if($key==3 || ($key-3)%4==0)
                    </div>
                @endif
            @endforeach


        </div>
    {!! $teachers->render() !!}
@endsection
