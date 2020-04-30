<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    <style>
        .container-fluid{
            max-width: 98%;
        }
        .navigation-menu>li>a
        {
            font-size:13px !important;
        }
        .table td, .table th
        {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <header class="bg-blue" id="topnav">
    @include('partials.topbar')
    @include('partials.sidebar')
    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper">
        <div class="container-fluid"> 
            <!-- start page title -->
            @if(isset($siteTitle))
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">{{ $siteTitle }}</h4>
                        </div>
                    </div>
                </div>
            @endif
            <!-- end page title --> 
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                        <div class="note note-info">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @yield('content')
        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        {{ App\Models\Setting::find(1)->footername }}
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>

</div>

{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

@include('partials.javascripts')
</body>
</html>
