@extends('layouts.layout')

@section('content')
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap drp-lst">
                        <h4>Classroom List</h4>
                        <div class="asset-inner">
                            <table>
                                <tr>
                                    <th>Class Id</th>
                                    <th>Capacity</th>
                                    <th>Modify the class</th>
                                    <th>Distance optimality</th>
                                    <th></th>

                                </tr>
                                @foreach($classrooms as $classroom)
                                    <tr>
                                        <td>{{$classroom->id}}</td>
                                        <td>{{$classroom->capacity}}</td>

                                        <td>
                                            @if($classroom->id)
                                                <a href="/classroom/composition/{{$classroom->id}}">
                                                    <button class="pd-setting">Class Composition</button>
                                                </a>
                                            @else
                                                <button class="ds-setting" style=" pointer-events: none;">No class
                                                </button>
                                            @endif
                                        </td>
                                        <td>{{$distance[$classroom->id]}}</td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Total Distance</td>
                                    <td></td>

                                    <td>

                                    </td>
                                    <td>{{$total}}</td>

                                    <td>

                                    </td>
                                </tr>

                            </table>
                        </div>
                        {!! $classrooms->render() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
