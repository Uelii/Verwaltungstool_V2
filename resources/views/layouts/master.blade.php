<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!--JavaScript & jQuery-->
        <!--DataTables-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
        <!--Bootstrap JavaScript-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!--Für Modals!<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>

    <!--CSS-->
        <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
        <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!--FontAwesome CSS (icons)-->
    <link rel="stylesheet" href="{{ URL::asset("css/font-awesome.css") }}" type="text/css">
        <!--Custom CSS-->
    <link rel="stylesheet" href="{{ URL::asset("css/main.css") }}" type="text/css">

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
            <img height="50px" width="50px" src="http://i0.wp.com/www.wehuntedthemammoth.com/wp-content/uploads/2016/02/pepetrump-600x600-2.png">
            <a class="navbar-brand" href="#">Grab 'em #maga</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <!--Check if visitor is a guest or a logged in user-->
                @if (!Auth::guest())
                    <li><a href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                    <li><a href="{{ url('/buildings') }}"><i class="fa fa-building-o" aria-hidden="true"></i> Buildings</a></li>
                    <li><a href="{{ url('/objects') }}"><i class="fa fa-bed" aria-hidden="true"></i> Objects</a></li>
                    <li><a href="#"><i class="fa fa-address-book-o" aria-hidden="true"></i> Renter</a></li>
                    <li><a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i> Invoices</a></li>
                    <li><a href="#"><i class="fa fa-money" aria-hidden="true"></i> Payments</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-file-o" aria-hidden="true"></i> Reports<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/report')}}" target="_blank">Create report</a></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>

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
        <p><i class="fa fa-copyright" aria-hidden="true"></i> Plebians - Web Engineering HS16/17</p>
    </div>
</footer>
<!--End footer-->


</body>
</html>