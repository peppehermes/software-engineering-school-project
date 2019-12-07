@extends('layouts.layout')

@section('content')
    <script>
        Date.prototype.getWeek = function (dowOffset) {
            /*getWeek() was developed by Nick Baicoianu at MeanFreePath: http://www.meanfreepath.com */

            dowOffset = typeof(dowOffset) == 'int' ? dowOffset : 0; //default dowOffset to zero
            var newYear = new Date(this.getFullYear(),0,1);
            var day = newYear.getDay() - dowOffset; //the day of week the year begins on
            day = (day >= 0 ? day : day + 7);
            var daynum = Math.floor((this.getTime() - newYear.getTime() -
                (this.getTimezoneOffset()-newYear.getTimezoneOffset())*60000)/86400000) + 1;
            var weeknum;
            //if the year starts before the middle of a week
            if(day < 4) {
                weeknum = Math.floor((daynum+day-1)/7) + 1;
                if(weeknum > 52) {
                    nYear = new Date(this.getFullYear() + 1,0,1);
                    nday = nYear.getDay() - dowOffset;
                    nday = nday >= 0 ? nday : nday + 7;
                    /*if the next year starts before the middle of
                      the week, it is week #1 of that year*/
                    weeknum = nday < 4 ? 1 : 53;
                }
            }
            else {
                weeknum = Math.floor((daynum+day-1)/7);
            }
            return weeknum;
        };

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


        function provideslots(week) {
            const today = new Date();
            var w = today.getWeek();
            w1 = week.id;

            w1 = w1.slice(6, 8);
            // current week greater than selected one
            if (w > w1) {
                alert('Sorry this week is already elapsed, you cannot provide any slots!');
                location.reload();
            }
            else {
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
                //selected more than 2 slots
                else if (slots.length > 2) {
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
                w1 = week.id;

            w1 = w1.slice(6, 8);

            if (w > w1) {
                alert('Sorry this week is already elapsed, you cannot free any slots!');
                location.reload();
            } else {
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
                        <h4>Year:{{ Str::limit($week,4,'')}},Week: {{ Str::substr($week,6,8)}}</h4>
                        <h4>Maximun  allowed:2</h4>
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
                                                <td dusk="slot{{$row}}" id="{{$row}}" bgcolor="green"
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
                                <button id="{{$week}}" name="button" type="submit" onclick="provideslots(this)"
                                        class="btn btn-primary waves-effect waves-light">
                                    Provide slots
                                </button>
                                <button id="{{$week}}" type="submit" onclick="freeslots(this)"
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

