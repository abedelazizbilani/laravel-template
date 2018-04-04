<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('Administration')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/laravel-template/public/adminlte/css/AdminLTE.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/laravel-template/public/css/bootstrap-datepicker.min.css">
    <!-- AdminLTE Skins. -->
    <link rel="stylesheet" href="/laravel-template/public/adminlte/css/skins/skin-blue.min.css">
    <!-- Bootstrap 4.0.0 -->
    <link rel="stylesheet" href="/laravel-template/public/css/app.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
@yield('css')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" id="app">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b><span class="fa fa-fw fa-dashboard"></span></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>@lang('Dashboard')</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Notifications Menu -->
                    @if ($countNotifications)
                        <li class="dropdown notifications-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>

                                <span class="label label-warning">{{ $countNotifications }}</span>

                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">@lang('New notifications')</li>
                                <li>
                                    <!-- Inner Menu: contains the notifications -->
                                    <ul class="menu">
                                        <li><!-- start notification -->
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> {{ $countNotifications }} @lang('new') {{ trans_choice(__('comment|comments'), $countNotifications) }}
                                            </a>
                                        </li>
                                        <!-- end notification -->
                                    </ul>
                                </li>
                                <li class="footer"><a
                                            href="{{ route('notifications.index', [auth()->id()]) }}">@lang('View')</a>
                                </li>
                            </ul>
                        </li>
                @endif

                <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            @if(Auth::user()->profile()->first()->image)
                                <img src="/{{ Auth::user()->profile()->first()->image }}" class="user-image">
                            @else
                                <img src="{{ Gravatar::get(auth()->user()->email) }}" class="user-image">
                            @endif
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            @if(Auth::user()->profile()->first()->first_name)
                                <span class="hidden-xs">{{ Auth::user()->profile()->first()->first_name }}</span>
                            @else
                                <span class="hidden-xs">{{ auth()->user()->name }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if(Auth::user()->profile()->first()->image)
                                    <img src="/{{ Auth::user()->profile()->first()->image }}" class="img-circle">
                                @else
                                    <img src="{{ Gravatar::get(auth()->user()->email) }}" class="user-image">
                                @endif
                                @if(Auth::user()->profile()->first()->first_name)
                                    <p>{{ Auth::user()->profile()->first()->first_name }}</p>
                                @else
                                    <p>{{ auth()->user()->name }}</p>
                                @endif
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a id="profiles" href="{{ route('profiles.edit', [Auth::user()->id]) }}"
                                       class="btn btn-default btn-flat">@lang('Profile')</a>
                                </div>
                                <div class="pull-right">
                                    <a id="logout" href="#" class="btn btn-default btn-flat">@lang('Sign out')</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Optionally, you can add icons to the links -->
                <li {{ currentRouteBootstrap('dashboard') }}>
                    <a href="{{ route('dashboard') }}"><i class="fa fa-fw fa-dashboard"></i>
                        <span>@lang('Dashboard')</span></a>
                </li>
                @include('back.partials.treeview', [
                  'icon' => 'cog',
                  'type' => 'setting',
                  'items' => [
                    [
                      'route' => route('users.index'),
                      'command' => 'users',
                      'color' => 'blue',
                      'can'     => 'manage_users'
                    ],
                    [
                      'route' => route('roles.index'),
                      'command' => 'roles',
                      'color' => 'green',
                      'can'     => 'manage_roles'
                    ],
                    [
                      'route' => route('devices.index'),
                      'command' => 'devices',
                      'color' => 'black',
                      'can'     => 'manage_roles'
                    ]
                  ]
                  ])
                @if ($countNotifications)
                    <li><a href="{{ route('notifications.index', [auth()->id()]) }}"><i class="fa fa-bell"></i>
                            <span>@lang('Notifications')</span></a></li>
                @endif

            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $title }}
                @yield('button')
            </h1>
            <ol class="breadcrumb">
                @foreach ($breadcrumbs as $item)
                    <li @if ($loop->last && $item['url'] === '#') class="active" @endif>
                        @if ($item['url'] !== '#')
                            <a href="{{ $item['url'] }}">
                                @endif
                                @isset($item['icon'])
                                    <span class="fa fa-{{ $item['icon'] }}"></span>
                                @endisset
                                {{ $item['name'] }}
                                @if ($item['url'] !== '#')
                            </a>
                        @endif
                    </li>
                @endforeach
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('main')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; <?= date("Y"); ?> <a
                    href="#">@lang('Idea To Life')</a>.</strong> @lang('All rights reserved') {{Route::currentRouteName()}}
        .
    </footer>

</div>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3.2.0 -->
<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>

<!-- Bootstrap 4.4.0 -->
<script src="/laravel-template/public/js/app.js"></script>

<!-- Date Picker -->
<script src="/laravel-template/public/js/bootstrap-datepicker.min.js"></script>

<!-- Sweet Alert -->
<script src="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>

@yield('js')

<!-- AdminLTE App -->
<script src="/laravel-template/public/adminlte/js/app.min.js"></script>


{{--we will use this in case fetching data --}}
{{--
   <script type="text/javascript">

   var map = new google.maps.Map(document.getElementById('map'), {
     mapTypeId: google.maps.MapTypeId.TERRAIN
   });

   var markerBounds = new google.maps.LatLngBounds();

   var randomPoint, i;

   for (i = 0; i < 10; i++) {
     // Generate 10 random points within North East USA
     randomPoint = new google.maps.LatLng( 39.00 + (Math.random() - 0.5) * 20,
                                          -77.00 + (Math.random() - 0.5) * 20);

     // Draw a marker for each random point
     new google.maps.Marker({
       position: randomPoint,
       map: map
     });

     // Extend markerBounds with each random point.
     markerBounds.extend(randomPoint);
   }

   // At the end markerBounds will be the smallest bounding box to contain
   // our 10 random points

   // Finally we can call the Map.fitBounds() method to set the map to fit
   // our markerBounds
   map.fitBounds(markerBounds);

   </script>
--}}

<script>

    $(function () {
        $('#logout').click(function (e) {
            e.preventDefault();
            $('#logout-form').submit()
        })
    });

    function initMap() {
        var latlong = {lat: 33.888630, lng: 35.495480};
        var bounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: latlong
        });
        var marker = new google.maps.Marker({
            position: latlong,
            map: map
        });
        bounds.extend(latlong);
        map.fitBounds(bounds);
    }

    $(document).on('shown.bs.tab', 'a[data-tab="map"]', function (e) {
        google.maps.event.trigger(map, 'resize');
    });

</script>
@if(strpos(Route::currentRouteName(), 'devices') !== false)
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsFAOn9V80RCKKzGdCtET8DNp1fm8zIMU&callback=initMap">
    </script>
@endif
</body>
</html>