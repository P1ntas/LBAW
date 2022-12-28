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
    <script src="https://kit.fontawesome.com/82c0a4cf1f.js" crossorigin="anonymous" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js" defer></script>
    <script type="text/javascript" src="{{ asset('js/header.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/faq.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/checkbox.js') }}" defer></script>
  </head>
  <body>
      @include('layouts.header')
      <main>
        <section id="content">
          @yield('content')
        </section>
      </main>
      @include('layouts.footer')
  </body>
</html>

