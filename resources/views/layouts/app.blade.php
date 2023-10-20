@php
  $pageTitle = $pageTitle ?? data_get(trans('site.title'), request()->route()->getName(), '');
  $pageTitle = (is_string($pageTitle) && !empty($pageTitle)) ? $pageTitle : env('APP_NAME');
@endphp
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ "菊水化学工業　基幹システム｜" . $pageTitle }}</title>
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  {{--  <link rel="shortcut icon" href="images/favicon.png"/>--}}
</head>
<body>
<div class="container-scroller">
  <!-- header -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo mr-5" href="{{ route('menu') }}">
        <img src="{{ asset('assets/images/logo.png') }}" class="mr-2" alt="logo"/>
      </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <h4 class="mb-0 mr-auto font-weight-bold">{{ $pageTitle }}</h4>
      <ul class="navbar-nav navbar-nav-right font-weight-bold">
        <li class="nav-item">{{ date('Y/m/d') }}</li>
        <li class="nav-item">{{ data_get(auth()->user(), 'user_id', '') }}</li>
        <li class="nav-item">{{ data_get(auth()->user(), 'user_nm', '') }}</li>
        <li class="nav-item">
          <a class="btn btn-info" href="{{ route('logout') }}">
            <i class="ti-power-off"></i>
            ログアウト
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid page-body-wrapper">
    <div class="main-panel">
      <div class="content-wrapper">
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        @if (session('danger'))
          <div class="alert alert-danger">
            {{ session('danger') }}
          </div>
        @endif
        @if (session('info'))
          <div class="alert alert-info">
            {{ session('info') }}
          </div>
        @endif
        @yield('main')
      </div>
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- js -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/ajaxzip3.js')}}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"> </script>
<script src="{{ asset('assets/js/common.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  });
  $('select[data-select="select2"]').select2({});
</script>
@stack('js')
</body>

</html>
