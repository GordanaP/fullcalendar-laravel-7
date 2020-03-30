<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Font -->
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

<!-- Fullcalendar -->
<link href="{{ asset('vendor/fullcalendar-4.3.1/packages/core/main.css') }}" rel='stylesheet' />
<link href="{{ asset('vendor/fullcalendar-4.3.1/packages/daygrid/main.css') }}" rel='stylesheet' />
<link href="{{ asset('vendor/fullcalendar-4.3.1/packages/timegrid/main.css') }}" rel='stylesheet' />
<link href="{{ asset('vendor/fullcalendar-4.3.1/packages/list/main.css') }}" rel='stylesheet' />

<!-- Datepicker -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui-1.12.1.purple/jquery-ui.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui-1.12.1.purple/jquery-ui.structure.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui-1.12.1.purple/jquery-ui.theme.css') }}">

<!-- Timepicker -->
<link rel="stylesheet" href="{{ asset('vendor/jonthornton-jquery-timepicker/jquery.timepicker.css') }}">

<!-- App styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@yield('links')