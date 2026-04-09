<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" wire:navigate>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Nexa Node') }}</title>
    <link rel="shortcut icon" href="{{ Storage::url('logos/nexa_node_darkmode.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> 
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link
    href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet"
    />

    <!-- Styles / Scripts -->
    <link rel="stylesheet" href="{{ asset('css/livewire/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/livewire/overflow.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/livewire/icon.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/livewire/daisyui.css') }}" type="text/css" />

    @livewireStyles
</head>

<body>

    @include('includes.navbar')
    {{ $slot }}
    @include('includes.footer')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrambleTextPlugin.min.js"></script>
    @stack('scripts')
</body>
</html>