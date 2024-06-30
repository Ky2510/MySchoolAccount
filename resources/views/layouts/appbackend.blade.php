<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('soft-ui-dashboard') }}/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('soft-ui-dashboard') }}/assets/img/favicon.png">
  <title>
    {{ @$title != '' ? "$title |" : '' }}  {{ settings()->get('app_name', 'My APP') }}
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('soft-ui-dashboard') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{ asset('soft-ui-dashboard') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('soft-ui-dashboard') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('soft-ui-dashboard') }}/assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('font/css/all.min.css') }}">
  <script>
    popupCenter = ({url, title, w, h}) => {
            // Fixes dual-screen position                             Most browsers      Firefox
            const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
            `
            scrollbars=yes,
            width=${w / systemZoom},
            height=${h / systemZoom},
            top=${top},
            left=${left}
            `
            )
            if (window.focus) newWindow.focus();
        }
  </script>
  <style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <!-- HTML markup untuk overlay -->
    <div class="overlay d-none" id="overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html" target="_blank">
        <img src="{{ asset('soft-ui-dashboard') }}/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">{{ settings()->get('app_name', 'My APP') }}</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
        @include('navbar')
    </div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
        <div class="full-background" style="background-image: url('{{ asset('soft-ui-dashboard') }}/assets/img/curved-images/white-curved.jpeg')"></div>
        <div class="card-body text-start p-3 w-100">
          <div class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
            <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true" id="sidenavCardIcon"></i>
          </div>
          <div class="docs-info">
            <h6 class="text-white up mb-0">Need help?</h6>
            <p class="text-xs font-weight-bold">Please check our docs</p>
            <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/soft-ui-dashboard" target="_blank" class="btn btn-white btn-sm w-100 mb-0">Documentation</a>
          </div>
        </div>
      </div>
      <a class="btn bg-gradient-primary mt-4 w-100" href="https://www.creative-tim.com/product/soft-ui-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
     <!-- Navbar -->
     <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Dashboard</h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
              <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {!! Form::open(['route' => 'tagihan.index', 'method' => 'GET']) !!}
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Pencarian Data Tagihan">
                </div>
                {!! Form::close() !!}
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item dropdown pe-2 d-flex align-items-center mx-3">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user fa-md cursor-pointer"></i>
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('user.edit', auth()->user()->id) }}">Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('setting.create') }}">Pengaturan</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center mx-3">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell fa-lg cursor-pointer"></i>
                        @if (auth()->user()->unreadNotifications->count() >= 1)
                            <span class="badge badge-pill bg-gradient-danger">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                    @if (auth()->user()->unreadNotifications->count() >= 1)
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            @foreach (auth()->user()->unreadNotifications as $notification)
                            <li class="mb-2">
                                <a href="{{ url($notification->data['url'] . '?id=' . $notification->id) }}" class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">{{ ucwords($notification->data['nama_wali']) }}</span><br>
                                            <span class="font-weight-bold" style="color: blue"> {{ $notification->data['messages'] }}</span><br>
                                            {{-- <span class="font-weight-bold">{{ $notification->data['messages1'] }}</span> --}}
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                            {{-- {{ diffForHumans($notification->created_at) }} --}}
                                        </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
           
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
         
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">

            <div class="alert d-none" role="alert"  id="alert-message">

            </div>

            @if($errors->any())
                <div class="alert" role="alert">
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </div>
            @endif

            @yield('content')
        </div>
      </div>
      <div class="row mt-4">
        @yield('data_tagihan')
      </div>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{ asset('soft-ui-dashboard') }}/assets/js/core/popper.min.js"></script>
  <script src="{{ asset('soft-ui-dashboard') }}/assets/js/core/bootstrap.min.js"></script>
  <script src="{{ asset('soft-ui-dashboard') }}/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('soft-ui-dashboard') }}/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="{{ asset('soft-ui-dashboard') }}/assets/js/plugins/chartjs.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  @yield('js')

  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <script src="{{ asset('js/select2.min.js') }}"></script>
  <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <!-- End custom js for this page -->
        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.rupiah').mask("#.##0", {reverse: true});
                $('.select2').select2();
            });
        </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('soft-ui-dashboard') }}/assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>
