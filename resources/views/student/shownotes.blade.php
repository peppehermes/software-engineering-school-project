@extends('layouts.layout')

@section('content')

<!-- Start Notes -->
<div class="widgets-programs-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="sparkline13-list" style="background: #f8fafc; padding-bottom: 20px">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="text-center text-capitalize">
                        <div class="main-sparkline13-hd">
                            <h1>NOTES<span class="table-project-n"></span></h1>
                        </div>
                    </div>

                    @foreach($notes as $key=>$note)
                        @if($key%2==0)
                            <div class="row">
                                @endif
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="hpanel widget-int-shape responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                                        <div class="panel-body">
                                            <div id="subject" class="stats-title pull-left">
                                                <h4>{{$note->subject}}</h4>
                                            </div>
                                            <div class="stats-icon pull-right">
                                                <i class="educate-icon educate-message"></i>
                                            </div>
                                            <div class="m-t-xl widget-cl-4">
                                                <h1 id="teacher" class="text-danger">{{$note->teachFirstName}} {{$note->teachLastName}}</h1>
                                                <div id='date' class="stats-row">
                                                    <h6>{{$note->date}}</h6>
                                                </div>
                                                <small id="note_description">{{$note->note}}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($key%2!=0)
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
