@extends('layouts.layout')

@section('content')
    <script>
      function selecttimeslot(slot){
           if( slot.style.backgroundColor=="orange")

               slot.style.backgroundColor="#7fff00";
           else
               slot.style.backgroundColor="orange";

           alert(slot.id);

        }



      function provideslots(){
          var slot,j=0;
          var slots=new Array();

          for(var i=1;i<37;i++){
            slot =document.getElementById(i);
              if( slot.style.backgroundColor=="orange"){
                  slots[j]=slot;
                  j++;
              }
          }

          if(slots.length>2) {
              alert('Sorry,too many slots selected!');
              window.location = "/meetings/add"
          }

          else{
             //Pass array slots to /meetings/store


          }



      }






    </script>
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
                                                <td id="{{$row}}" bgcolor="#7fff00" onclick="selecttimeslot(this)">{{''}}</td>
                                                @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                        </div>


                    </div>
                    <div class="row" style="margin-top: 50px">
                        <div class="col-lg-12">
                            <div class="payment-adress">
                    <button type="submit" onclick="provideslots()"
                            class="btn btn-primary waves-effect waves-light">
                        Provide slots
                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

