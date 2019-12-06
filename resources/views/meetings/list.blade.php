@extends('layouts.layout')

@section('content')

    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <h4>Timeslots of Professor {{$teach->firstName}} {{$teach->lastName}}</h4>

                        <div class="asset-inner">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Time</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>

                                </tr>
                                </thead>


                                @foreach($times as $key=>$time)
                                    {{--                                    @php $count=$count+1; @endphp--}}
                                    <tr>
                                        <td>{{$key}}</td>
                                        @foreach($time as $row)
                                            @php $bool=1;
                                            @endphp
                                            @foreach($timeslots as $timeslot)
                                                @if($row==$timeslot->id)
                                                    <td id="{{$row}}" bgcolor="#dc143c">{{$timeslot->subject}}</td>
                                                    @php $bool=0;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @foreach($provided as $prov)
                                                @if($row==$prov->idTimeslot)
                                                    <td id="{{$row}}" bgcolor="#00008b">{{''}}</td>
                                                    @php $bool=0;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @if($bool==1)
                                                <td id="{{$row}}" bgcolor="green"
                                                    onclick="selecttimeslot(this)">{{''}}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                            <h5 class="box-title">Slots Status</h5>
                            <ul class="basic-list">
                                <li>Already provided <span class="pull-right label-danger label-1 label"> </span></li>
                                <li>Lecture's Hour <span class="pull-right label-info label-4 label"> </span></li>
                                <li>Availabe <span class="pull-right label-success label-3 label"> </span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


