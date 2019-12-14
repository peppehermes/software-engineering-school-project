@extends('layouts.layout')

@section('content')

    <script>

        function selecttimeslot_orange(slot) {
            if (slot.style.backgroundColor == "black")
                slot.style.backgroundColor = "rebeccapurple";
            else
                slot.style.backgroundColor = "lightblue";
        }

        function selecttimeslot_green(slot) {
            if (slot.style.backgroundColor == "orange")
                slot.style.backgroundColor = "lightblue";
            else
                slot.style.backgroundColor = "orange";
        }

        function bookslot(week) {
            stud = "{{$idStud}}";
            teach = "{{$teach->id}}";

            var slot, j = 0;
            var slots = new Array();

            for (var i = 1; i < 37; i++) {
                slot = document.getElementById(i);
                console.log(slot);
                //collect ids of selected slots
                if (slot.style.backgroundColor == "orange") {
                    slots[j] = slot.id;
                    j++;
                }
            }
            //no slots selected
            if (slots.length == 0) {
                alert('Please, select at least one available slot to book!');
                location.reload()
            }
            //selected more than 2 slots
            else if (slots.length > 1) {
                alert('Sorry, you can only book one slot!');
                location.reload()
            } else {
                //Pass array slots to /meetings/storeforparents
                dataString = slots; // array?
                var jsonString = JSON.stringify(dataString);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/meetings/storeforparents",
                    data: {data: jsonString, week: week.id, myStudent: stud, teacher: teach},
                    cache: false,

                    success: function (data) {
                        if (data != 0) {
                            alert(data);
                            location.reload()
                        } else {
                            alert('Selected Slot successfully booked from you!');
                            location.reload()
                        }

                    }
                });

            }

        }

        function freeslot(week) {
            teach = "{{$teach->id}}";
            var slot, j = 0;
            var slots = new Array();

            for (var i = 1; i < 37; i++) {
                slot = document.getElementById(i);
                console.log(slot);
                if (slot.style.backgroundColor == "lightblue") {
                    slots[j] = slot.id;
                    j++;
                }
            }

            if (slots.length == 0) {
                alert('Please, select at least one Booked Slot to free!');
                location.reload()
            } else {
                //Pass array slots to /meetings/free
                dataString = slots; // array?
                var jsonString = JSON.stringify(dataString);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/meetings/freeforparents",
                    data: {data: jsonString, week: week.id, teacher: teach},
                    cache: false,

                    success: function (data) {
                        alert('Selected Slot successfully freed!');
                        location.reload()
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
                        <h4>Timeslots of Professor {{$teach->firstName}} {{$teach->lastName}} </h4>
                        <h5 style="color: #ca1616"> Maximum booking allowed: 1</h5>
                        <h5 style="text-align: center;color: #319209">({{$date1}} - {{$date2}})</h5>
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

                                                {{-- CASE RED - The Teacher has a lecture on that slot --}}
                                                @if($row==$timeslot->id)
                                                    <td id="{{$row}}" bgcolor="#545151"
                                                        style="color: white">{{$timeslot->idClass}} {{$timeslot->subject}}</td>
                                                    @php $bool=0;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @foreach($provided as $prov)
                                                @if($row==$prov->idTimeslot)

                                                    {{-- CASE ORANGE - The slot is booked by the user --}}
                                                    @if($prov->isBooked == 1 && $prov->idParent == \Auth::user()->id)
                                                        <td onclick="selecttimeslot_orange(this) " id="{{$row}}"
                                                            bgcolor="rebeccapurple">{{''}}</td>
                                                        @php $bool=0;
                                                        @endphp


                                                        {{-- CASE BLUE - The slot is booked by another user --}}
                                                    @elseif($prov->isBooked == 1 && $prov->idParent != \Auth::user()->id)
                                                        <td id="{{$row}}" bgcolor="#0259c1">{{''}}</td>
                                                        @php $bool=0;
                                                        @endphp

                                                        {{-- CASE GREEN - The slot is available --}}
                                                    @elseif($prov->isBooked == 0)
                                                        <td dusk="slot{{$row}}" onclick="selecttimeslot_green(this)"
                                                            id="{{$row}}" bgcolor="lightblue"
                                                            style="cursor: pointer">{{''}}</td>
                                                        @php $bool=0;
                                                        @endphp
                                                    @endif
                                                @endif
                                            @endforeach


                                            {{-- CASE GREY - The slot has not been made available --}}
                                            @if($bool==1)
                                                <td id="{{$row}}" bgcolor="#b9b7b7">{{''}}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                            <h5 class="box-title">Slots Status</h5>
                            <ul class="basic-list">
                                <li>Not Available <span class="pull-right label-purple label-7 label"> </span></li>
                                <li>Lecture's hour <span class="pull-right label-purple label-8 label"> </span></li>
                                <li>Your Booking <span class="pull-right label-purple label-9 label"> </span></li>
                                <li>Other Booking <span class="pull-right label-purple label-10 label"> </span></li>
                                <li>Available <span class="pull-right label-purple label-11 label"> </span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 40px">
                        <div class="col-lg-12">
                            <div class="payment-adress">
                                <button id="{{$week}}" name="button" type="submit" onclick="bookslot(this)"
                                        class="btn btn-primary waves-effect waves-light">
                                    Book Slot
                                </button>
                                <button id="{{$week}}" type="submit" onclick="freeslot(this)"
                                        class="btn btn-primary waves-effect waves-light">
                                    Free Slot
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
