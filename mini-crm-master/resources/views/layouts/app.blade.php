<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user" content="{{ Auth::user() }}">
  
  <title>Mini CRM - @yield('title')</title>
  
  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css')}} " type="text/css">
  @stack('styles')
  @yield('styles')
</head>
<body>
<main class="main" role="main" id="app" v-cloak>
  @include('layouts.header')
  @yield('content')
  @include('layouts.footer')
</main>
@stack('scripts-before')
<script data-pace-options='{ "eventLag": true }' src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
@routes
<script>
  window.default_locale = "{{ config('app.locale') }}";
  window.fallback_locale = "{{ config('app.fallback_locale') }}";
  window.messages = @json($messages);
</script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
@yield('scripts')
</body>
</html>