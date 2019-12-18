@extends('layouts.layout')

@section('content')

    <!-- Static Table Start -->
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Material<span class="table-project-n"></span></h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">

                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                       data-show-columns="true" data-show-pagination-switch="true"
                                       data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                       data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                       data-toolbar="#toolbar" class="table-striped table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>ClassRoom</th>
                                        <th>Teacher</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Support Material</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($materials as $material)

                                        <tr>
                                            <td>{{$material->idClass}}</td>
                                            <td>{{$material->firstName}} {{$material->lastName}}</td>
                                            <td>{{$material->subject}} </td>
                                            <td>{{$material->date}}</td>
                                            <td class="description">{{$material->mdescription}}</td>
                                            <td>
                                                <a href="{{ asset('/uploads/'.$material->material) }}" target="_blank"
                                                   class="btn btn-primary btn-lg active" role="button"
                                                   aria-pressed="true">Download</a>
                                            </td>

                                        </tr>

                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Static Table End -->



@endsection
