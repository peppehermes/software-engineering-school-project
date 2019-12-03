@extends('layouts.layout')

@section('content')

    <!-- Start Notes -->
    <div class="widgets-programs-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-hd text-center text-capitalize">
                        <div class="main-sparkline13-hd">
                            <h1>NOTES<span class="table-project-n"></span></h1>
                        </div>
                    </div>
                </div>
                @foreach($notes as $note)
                    <div class="float-lg-left col-lg-offset-1 col-lg-10
                     col-md-offset-2 col-md-8
                     col-sm-offset-2 col-sm-8
                     col-xs-12" style="margin-top: 30px">
                        <div class="hpanel">
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
                @endforeach
            </div>
        </div>
    </div>

@endsection
