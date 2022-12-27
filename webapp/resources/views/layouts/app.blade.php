<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js" defer></script>
    <script type="text/javascript" src="{{ asset('js/header.js') }}" defer></script>
  </head>
  <body>
    <main>
      @include('layouts.header')
      <section id="content">
        @yield('content')
      </section>
      @include('layouts.footer')
    </main>
  </body>
</html>

