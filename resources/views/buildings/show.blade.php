<!--Layout to show one specific building-->

@extends('layouts.master')

@section('title')
    SHOW-Building
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Building details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Building</div>
                    <div class="panel-body">
                        <h3>{{ $building->name }}</h3>
                        <hr>
                        <p><b>Street: </b>{{ $building->street }}</p>
                        <p><b>Street number: </b>{{ $building->street_number }}</p>
                        <p><b>Zip code: </b>{{ $building->zip_code }}</p>
                        <p><b>City: </b>{{ $building->city }}</p>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/buildings') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="row objects">
        <div class="col-md-12 objects">
            <h4>Objects correspondending to this building</h4>
            <hr>
            <div class="table-responsive">
                <table id="objects_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sqm</th>
                        <th>No. of rooms</th>
                        <th>Floor/room no.</th>
                        <th>Rent</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($building->object as $object)
                        <tr>
                            <td>{{ $object->name }}</td>
                            <td>{{ $object->living_space }}</td>
                            <td>{{ $object->number_of_rooms }}</td>
                            <td>{{ $object->floor_room_number }}</td>
                            <td>p.a. {{ $object->rent }} Fr. </br> p.m. {{number_format(( $object->rent/12 ), 2)}} Fr.</td>
                            <td>
                                <a href="{{ route('objects.show', $object->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                                <a href="{{ route('objects.edit', $object->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>

                                <!--Check if an object-renter relation exists (if so: show a warning button)-->
                                @if(count($object->renter))
                                    <button type="button" class="btn btn-warning" data-toggle="deletion_popover"
                                            title="Deletion not possible." data-content="There are some renters attached to this object. Therefore this object cannot be deleted."
                                            data-trigger="focus"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Note</button>
                                    <script>
                                        addPopover();
                                    </script>
                                @else
                                    <a href="#modalDelete_{{ $building->id }}" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!--jQuery option to sort table data-->
                <script>
                    addSortTableOptions('objects_data');
                </script>

            </div>
        </div>
    </section>
@endsection