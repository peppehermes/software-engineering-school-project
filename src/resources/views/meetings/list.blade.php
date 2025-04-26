@extends('layouts.layout')

@section('content')
    <script>
        Date.prototype.getWeek = function (dowOffset) {
            dowOffset = typeof (dowOffset) == 'int' ? dowOffset : 0; //default dowOffset to zero
            var newYear = new Date(this.getFullYear(), 0, 1);
            var day = newYear.getDay() - dowOffset; //the day of week the year begins on
            day = (day >= 0 ? day : day + 7);
            var daynum = Math.floor((this.getTime() - newYear.getTime() -
                (this.getTimezoneOffset() - newYear.getTimezoneOffset()) * 60000) / 86400000) + 1;
            var weeknum;
            //if the year starts before the middle of a week
            if (day < 4) {
                weeknum = Math.floor((daynum + day - 1) / 7) + 1;
                if (weeknum > 52) {
                    nYear = new Date(this.getFullYear() + 1, 0, 1);
                    nday = nYear.getDay() - dowOffset;
                    nday = nday >= 0 ? nday : nday + 7;
                    /*if the next year starts before the middle of
                      the week, it is week #1 of that year*/
                    weeknum = nday < 4 ? 1 : 53;
                }
            } else {
                weeknum = Math.floor((daynum + day - 1) / 7);
            }
            return weeknum;
        };

        function selecttimeslot(slot) {
            const today = new Date();
            var w = today.getWeek(),
                year = today.getFullYear(),
                day= today.getDay();
                week="{{$week}}";

            w1 = week.slice(6, 8);
            y1 = week.slice(0, 4);

            if(w1==w && y1==year) {

                    if (day == 1 && slot.id < 7) {
                        alert('You cannot provide slots for this day');
                        location.reload()
                    }
                    else if(day == 2 && slot.id < 13) {
                        alert('You cannot provide slots for this day');
                        location.reload()
                    }
                    else if(day == 3 && slot.id < 19) {
                        alert('You cannot provide slots for this day');
                        location.reload()
                    }
                    else if(day == 4 && slot.id < 25) {
                        alert('You cannot provide slots for this day');
                        location.reload()
                    }
                    else if(day == 5 && slot.id < 31) {
                        alert('You cannot provide slots for this day');
                        location.reload()
                    }
                    else if (day==6 || day==7) {
                        alert('You cannot provide slots for this day');
                        location.reload()
                    }
                    else {

                        if (slot.style.backgroundColor == "orange")

                            slot.style.backgroundColor = "lightblue";

                        else
                            slot.style.backgroundColor = "orange";
                    }
            }
            else {

                if (slot.style.backgroundColor == "orange")

                slot.style.backgroundColor = "lightblue";

                else
                slot.style.backgroundColor = "orange";
            }
        }

        function selecttimeslot1(slot) {
            const today = new Date();
            var w = today.getWeek(),
                year = today.getFullYear(),
                day= today.getDay();
            week="{{$week}}";

            w1 = week.slice(6, 8);
            y1 = week.slice(0, 4);

            if(w1==w && y1==year) {

                if (day == 1 && slot.id < 7) {
                    alert('You cannot free slots for this day');
                    location.reload()
                }
                else if(day == 2 && slot.id < 13) {
                    alert('You cannot free slots for this day');
                    location.reload()
                }
                else if(day == 3 && slot.id < 19) {
                    alert('You cannot free slots for this day');
                    location.reload()
                }
                else if(day == 4 && slot.id < 25) {
                    alert('You cannot free slots for this day');
                    location.reload()
                }
                else if(day == 5 && slot.id < 31) {
                    alert('You cannot free slots for this day');
                    location.reload()
                }
                else if (day==6 || day==7) {
                    alert('You cannot free slots for this day');
                    location.reload()
                }
                else {
                    if (slot.style.backgroundColor == "lightblue")

                        slot.style.backgroundColor = "#663399";

                    else
                        slot.style.backgroundColor = "lightblue";

                }
            }
            else {

                if (slot.style.backgroundColor == "lightblue")

                    slot.style.backgroundColor = "#663399";

                else
                    slot.style.backgroundColor = "lightblue";
            }
        }

        function provideslots(week) {
            const today = new Date();
            var w = today.getWeek(),
                year = today.getFullYear();

            w1 = week.id;
            y1 = week.id;

            w1 = w1.slice(6, 8);
            y1 = y1.slice(0, 4);
            // current week greater than selected one
            if (w > w1 && y1 == year) {
                alert('Sorry this week is already elapsed, you cannot provide any slot!');
                location.reload();
            } else {
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
                    alert('Please, select at least one free slot to provide!');
                    location.reload()
                }
                //selected more than 3 slots
                else if (slots.length > 3) {
                    alert('Sorry,too many slots selected!');
                    location.reload()
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
                        data: {data: jsonString, week: week.id},
                        cache: false,

                        success: function (data) {
                            if (data != 0) {
                                alert(data);
                                location.reload()
                            } else {
                                alert('Selected slots successfully provided!');
                                location.reload()
                            }

                        }
                    });

                }
            }
        }

        function freeslots(week) {
            const today = new Date();
            var w = today.getWeek(),
                year = today.getFullYear();

            w1 = week.id;
            y1 = week.id;

            w1 = w1.slice(6, 8);
            y1 = y1.slice(0, 4);

            if (w > w1 && y1 == year) {
                alert('Sorry this week is already elapsed, you cannot free any slot!');
                location.reload();
            } else {
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
                    alert('Please, select at least one blue slot to free!');
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
                        url: "/meetings/free",
                        data: {data: jsonString, week: week.id},
                        cache: false,

                        success: function (data) {
                            alert('Selected slots successfully set free!');
                            location.reload()
                        }
                    });
                }
            }
        }

    </script>
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <h4>Timeslots of Professor {{$teach->firstName}} {{$teach->lastName}}</h4>
                        <h5 style="color: #ca1616"> Maximum booking allowed: 3</h5>
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
                                                @if($row==$timeslot->id)
                                                    <td id="{{$row}}" style="color: white"
                                                        bgcolor="#555">{{$timeslot->idClass}} {{$timeslot->subject}}</td>
                                                    @php $bool=0;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @foreach($provided as $prov)
                                                @if($row==$prov->idTimeslot)
                                                    @if($prov->isBooked==1)
                                                        <td id="{{$row}}" style="color: white" bgcolor="#0259c1"><b>Parent: {{$prov->name}}</b>
                                                            <p><b>Student: {{$prov->firstName}} {{$prov->lastName}}</b>
                                                        </td>

                                                    @else
                                                        <td onclick="selecttimeslot1(this)" style="cursor: pointer" id="{{$row}}"
                                                            bgcolor="#663399">{{''}}</td>
                                                    @endif
                                                    @php $bool=0;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @if($bool==1)
                                                <td dusk="slot{{$row}}" id="{{$row}}" style="cursor: pointer"
                                                    bgcolor="lightblue"
                                                    onclick="selecttimeslot(this)">{{''}}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                            <h5 class="box-title">Slots Status</h5>
                            <ul class="basic-list">
                                <li>Booked<span class="pull-right label-purple label-10 label"> </span></li>
                                <li>Bookable<span class="pull-right label-purple label-9 label"> </span></li>
                                <li>Lecture's hour <span class="pull-right label-purple label-7 label"> </span></li>
                                <li>Available <span class="pull-right label-purple label-11 label"> </span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 40px">
                        <div class="col-lg-12">
                            <div class="payment-adress">
                                <button id="{{$week}}" name="button" type="submit" onclick="provideslots(this)"
                                        class="btn btn-primary waves-effect waves-light  btn-lg">
                                    Provide slots
                                </button>
                                <button id="{{$week}}" type="submit" onclick="freeslots(this)"
                                        class="btn btn-primary waves-effect waves-light btn-lg">
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

