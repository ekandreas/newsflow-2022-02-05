<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Newsflow</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('/dist/css/app.css') }}" rel="stylesheet">
    @livewireStyles
    @stack('header')
</head>

<body>

    @yield('content')

    @livewireScripts
    @stack('scripts')

</body>

</html>
