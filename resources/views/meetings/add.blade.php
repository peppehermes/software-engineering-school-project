@extends('layouts.layout')

@section('content')
    <script>
        function selecttimeslot(slot) {
            if (slot.style.backgroundColor == "orange")

                slot.style.backgroundColor = "green";

            else
                slot.style.backgroundColor = "orange";
        }

        function selecttimeslot1(slot) {
            if (slot.style.backgroundColor == "white")

                slot.style.backgroundColor = "#00008b";

            else
                slot.style.backgroundColor = "white";
        }


        function provideslots() {
            var slot, j = 0;
            var slots = new Array();

            for (var i = 1; i < 37; i++) {
                slot = document.getElementById(i);
                console.log(slot);
                if (slot.style.backgroundColor == "orange") {
                    slots[j] = slot.id;
                    j++;
                }
            }

            if (slots.length == 0) {
                alert('Please, select at least one slot to provide!');
                window.location = "/meetings/add"
            }
            else if (slots.length > 2) {
                alert('Sorry,too many slots selected!');
                window.location = "/meetings/add"
            } else {
                //Pass array slots to /meetings/store
                dataString = slots; // array?
                var jsonString = JSON.stringify(dataString);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/meetings/store",
                    data: {data: jsonString},
                    cache: false,

                    success: function (data) {
                        if(data!=0) {
                            alert(data);
                            window.location = "/meetings/add"
                        }
                        else{
                            alert('Selected slot successfully provided!');
                            window.location = "/meetings/list"
                        }

                    }
                });

            }
        }

        function freeslots() {
            var slot, j = 0;
            var slots = new Array();

            for (var i = 1; i < 37; i++) {
                slot = document.getElementById(i);
                console.log(slot);
                if (slot.style.backgroundColor == "white") {
                    slots[j] = slot.id;
                    j++;
                }
            }

            if (slots.length == 0) {
                alert('Please, select at least one slot to free!');
                window.location = "/meetings/add"
            }
            else {
                //Pass array slots to /meetings/store
                dataString = slots; // array?
                var jsonString = JSON.stringify(dataString);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/meetings/free",
                    data: {data: jsonString},
                    cache: false,

                    success: function (data) {
                        alert('Slots successfully set free!');
                        window.location = "/meetings/list"
                    }
                });
            }
        }

    </script>
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <h4>Timeslots of Professor {{$teach->firstName}} {{$teach->lastName}}<p></p> Maximun  allowed:2</h4>

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
                                                    <td onclick="selecttimeslot1(this)"id="{{$row}}" bgcolor="#00008b">{{''}}</td>
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

                    <div class="row" style="margin-top: 40px">
                        <div class="col-lg-12">
                            <div class="payment-adress">
                                <button type="submit" onclick="provideslots()"
                                        class="btn btn-primary waves-effect waves-light">
                                    Provide slots
                                </button>
                                <button type="submit" onclick="freeslots()"
                                        class="btn btn-primary waves-effect waves-light">
                                    Free slots
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

