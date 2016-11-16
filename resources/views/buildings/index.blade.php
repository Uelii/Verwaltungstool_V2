<!--Layout to show all buildings-->

@extends('layouts.master')

@section('title')
    INDEX-Buildings
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h2>Overview Buildings</h2>
            <hr>

            <div class="table-responsive">
            <table id="buildings_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Street</th>
                    <th>Street number</th>
                    <th>Zip code</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
                </thead>

                <!--Display data-->
                <tbody>
                @foreach($buildings as $building)
                    <tr>
                        <td>{{ $building->name }}</td>
                        <td>{{ $building->street }}</td>
                        <td>{{ $building->street_number }}</td>
                        <td>{{ $building->zip_code }}</td>
                        <td>{{ $building->city }}</td>
                        <td>
                            <a href="{{ route('buildings.show', $building->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                            <a href="{{ route('buildings.edit', $building->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>

                            <!--Check if relation exists (if so: show a warning button)-->
                            @if(count($building->object))
                                <button type="button" class="btn btn-warning" data-toggle="deletion_popover"
                                        title="Deletion not possible." data-content="Due to foreign key constraints this building cannot be deleted."
                                        data-trigger="focus"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Note</button>
                                <script>
                                    $(document).ready(function(){
                                        $('[data-toggle="deletion_popover"]').popover();
                                    });
                                </script>
                            @else
                                <a href="#modalDelete_{{ $building->id }}" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            @endif

                            <!-- Modal -->
                            <div class="modal fade" id="modalDelete_{{ $building->id }}" tabIndex="-1">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                ×
                                            </button>
                                            <h4 class="modal-title">Please confirm</h4>
                                        </div>
                                        <div class="modal-body">
                                            Dou you really want to delete this building?
                                            </br>
                                            <h3>{{ $building->name }}</h3>
                                            <hr>
                                            <p><b>Street: </b>{{ $building->street }}</p>
                                            <p><b>Street number: </b>{{ $building->street_number }}</p>
                                            <p><b>Zip code: </b>{{ $building->zip_code }}</p>
                                            <p><b>City: </b>{{ $building->city }}</p>
                                        </div>
                                        <div class="modal-footer">

                                            <form class="form-horizontal" role="form" method="POST"
                                                  action="{{ url('/buildings', $building->id)}}">

                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Yes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!--jQuery option to sort table data-->
            <script>
                $(document).ready(function(){
                    $("#buildings_data").DataTable( {
                        responsive: true,
                        oLanguage: { "sSearch": '<i class="fa fa-search" aria-hidden="true"></i>'}
                    });
                });
            </script>

            <a href="{{ url('/buildings/create')}}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new building</a>
            </div>
            </div>
    </section>
@endsection