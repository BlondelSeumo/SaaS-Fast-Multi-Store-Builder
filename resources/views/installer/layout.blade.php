<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ __('Ecom Installer') }}</title>
    <link href="<?= url('img/favicon/logo.png') ?>" rel="shortcut icon" type="image/png" />
    <!-- Styles --> 
    @foreach(['bootstrap.css', 'app.css', 'home.css'] as $file)
    <link href="<?= asset('css/' . $file . '?v=') ?>" rel="stylesheet">
    @endforeach
    <!-- Scripts -->
    <script src="{{ asset('js/bundle.js') }}"></script>
</head>
<body class="installer">
    @yield('content')
    <a class="dark-mode">
     <em class="icon ni ni-moon"></em>
    </a>
    <!-- END FOOTER -->
    @foreach(['pickr.es5.min.js', 'jq.multiinput.js', 'custom.js', 'bootstrap-tagsinput.js', 'scripts.js'] as $file)
    <script src="{{ asset('js/' .$file. '?v=') }}"></script>
    @endforeach
</body>
</html>
