<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon.ico') }}">

    <title>{{ $title ?? env('APP_NAME') }}</title>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    
    @endif
  </head>
  <body
    x-data="{'loaded': true, 'darkMode': false, 'stickyMenu': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    @include('components.preloader')
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    @yield('content')
    <!-- ===== Page Wrapper End ===== -->

    <!-- ===== Toast Start ===== -->
    @if(session('success'))
      <x-toast 
          type="success" 
          :message="session('success')"
      />
    @endif

    @if(session('error') || $errors->any())
        <x-toast 
            type="error" 
            :message="session('error') ?? 'Something went wrong'"
        />
    @endif

    @if(session('warning'))
      <x-toast 
          type="warning" 
          :message="session('warning')"
      />
    @endif

    @if(session('info'))
      <x-toast 
          type="info" 
          :message="session('info')"
      />
    @endif
    <!-- ===== Toast End ===== -->
  </body>
</html>