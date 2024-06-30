<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>
        {{ @$title != '' ? "$title |" : '' }}  {{ settings()->get('app_name', 'My APP') }}
    </title>
    <link rel="stylesheet" href="{{ asset('layouts_backend') }}/assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="{{ asset('layouts_backend') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="{{ asset('layouts_backend') }}/assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="{{ asset('layouts_backend') }}/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ asset('layouts_backend') }}/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="{{ asset('layouts_backend') }}/assets/css/style.css" />
    <link rel="shortcut icon" href="{{ asset('layouts_backend') }}/assets/images/favicon.png" />
    <link rel="stylesheet" href="{{ asset('font/css/all.min.css') }}">
    <style>
        body {
           background: #eee;
        }
    </style>
  </head>
  <body>
        @yield('content')
  </body>
</html>
