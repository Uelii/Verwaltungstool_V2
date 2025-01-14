<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!--JavaScript & jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!--DataTables-->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
        <!--Bootstrap JavaScript-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!--Für Modals!<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>

    <script src="{{ URL::asset("js/custom.js") }}" type="text/javascript"></script>

    <!--CSS-->
        <!--jQuery UI-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
        <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!--FontAwesome CSS (icons)-->
    <link rel="stylesheet" href="{{ URL::asset("css/font-awesome.css") }}" type="text/css">
        <!--Custom CSS-->
    <link rel="stylesheet" href="{{ URL::asset("css/main.css") }}" type="text/css">

    <link rel="icon" href="{{ URL::asset("favicon.ico") }}">

</head>
<body>

<!--Navigation-->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ url('/home') }}"> <img class="header_image" src="/immogate/public/img/immoGate_v1.png"></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <!--Check if visitor is a guest or a logged in user-->
                @if (!Auth::guest())
                    <li><a href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                    <li><a href="{{ url('/buildings') }}"><i class="fa fa-building-o" aria-hidden="true"></i> Buildings</a></li>
                    <li><a href="{{ url('/objects') }}"><i class="fa fa-bed" aria-hidden="true"></i> Objects</a></li>
                    <li><a href="{{ url('/renter') }}"><i class="fa fa-address-book-o" aria-hidden="true"></i> Renter</a></li>
                    <li><a href="{{ url('/payments') }}"><i class="fa fa-money" aria-hidden="true"></i> Payments</a></li>
                    <li><a href="{{ url('/invoices') }}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Invoices</a></li>
                    <li><a href="{{ url('/report') }}"><i class="fa fa-file-o" aria-hidden="true"></i> Reports</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--Check if visitor is a guest or a logged in user-->
                @if (Auth::guest())
                    <li><a href="{{ url('/') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
                    <li><a href="{{ url('/register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!--End navigation-->

<!--Main content-->
<section class="container-fluid">

    <!--Success-message output-->
    @if(Session::has('success_message'))
        <div class="alert alert-success">
            {{ Session::get('success_message') }}
        </div>
    @endif

    <!--Error-message output-->
    @if(Session::has('error_message'))
        <div class="alert alert-danger">
            {{ Session::get('error_message') }}
        </div>
    @endif

    @yield('content')

</section>
<!--End main content-->

<!--Footer-->
<footer class="footer">
    <div class="container-fluid">
        <p><i class="fa fa-copyright" aria-hidden="true"></i> F. Kipfer | M. Konrad | R. Meilbeck - Web Engineering HS16/17</p>
    </div>
</footer>
<!--End footer-->

</body>
</html>