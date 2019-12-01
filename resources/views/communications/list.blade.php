@extends('layouts.layout')

@section('content')


        <div class="login-form-area edu-pd mg-b-15">
            <div class="container-fluid">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="tab-content-details shadow-reset">
                            <h2>Virtual Board</h2>
                            <p>Here you can see all Official Communications published.</p>
                        </div>
                    </div>
                </div>

                @foreach($communications as $communication)



                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                            <div class="modal-bootstrap shadow-inner mg-tb-30 responsive-mg-b-0">
                                <h2>{{$communication->user_name}} ( {{$communication->date}} )</h2>
                                <p>{{$communication->description}}</p>
                            </div>
                        </div>

                    </div>





                @endforeach


            </div>
        </div>




@endsection
