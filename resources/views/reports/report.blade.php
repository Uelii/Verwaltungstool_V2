<!--Layout to create reports-->

@extends('layouts.master')

@section('title')
    Reports
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h2>Create report</h2>
            <hr>

            <p>Dropdown Liegenschaft auswahl</p>
            <p>Von...bis...</p>
            <p>Ort, Datum für Mieterabrechnung</p>
            <p>Buttons: Was für eine Art von PDF/Report?</p>

            <a href="{{ url('/building_overview_pdf')}}" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Create</a>
        </div>
    </section>
@endsection