<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-white antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#1a1c29]">
        <div>
            <a href="/" class="flex flex-col items-center gap-4 hover:scale-105 transition-transform drop-shadow-[0_0_15px_rgba(246,70,104,0.3)]">
                <img src="{{ asset('assets/logo.svg') }}" class="w-20 h-20 object-contain drop-shadow-[0_0_8px_rgba(254,150,119,0.5)]" alt="EasyColoc Logo" />
                <span class="text-4xl font-black tracking-widest uppercase bg-gradient-to-r from-[#FE9677] to-[#F64668] bg-clip-text text-transparent">
                    EasyColoc
                </span>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-[#1e2030] border-2 border-[#984063] rounded-[22px] text-white shadow-2xl overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</body>

</html>