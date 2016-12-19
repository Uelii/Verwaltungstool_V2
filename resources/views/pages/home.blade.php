@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2"> <!--offset=(12-8)/2-->
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <p>You are now logged in. Have fun testing our laravel administration app!</p>
                    <p>Best regards, </br>
                    Fabian Kipfer, Michel Konrad, Rene Meilbeck
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
