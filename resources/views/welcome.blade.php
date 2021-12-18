<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Newsflow</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body>

    <livewire:public.heros.intro-hero />
    <livewire:public.footers.simple-footer />

    @livewireScripts
</body>

</html>
