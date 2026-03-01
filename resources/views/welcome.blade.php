<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-[#0f1015] text-white selection:bg-[#F64668] selection:text-white flex flex-col min-h-screen font-sans">
    <nav class="w-full px-6 py-4 flex justify-between items-center max-w-7xl mx-auto border-b border-[#41436A]/50">
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/logo.svg') }}" class="w-10 h-10 object-contain drop-shadow-[0_0_8px_rgba(254,150,119,0.5)]" alt="EasyColoc Logo" />
            <span class="text-2xl font-black tracking-widest uppercase bg-gradient-to-r from-[#FE9677] to-[#F64668] bg-clip-text text-transparent">
                EasyColoc
            </span>
        </div>

        @if (Route::has('login'))
        <div class="flex items-center gap-4">
            @auth
            <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-bold uppercase tracking-widest text-white bg-[#1e2030] hover:bg-[#FE9677] hover:text-[#0f1015] border border-[#41436A] hover:border-[#FE9677] transition-all rounded-lg shadow-lg">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-widest text-gray-300 hover:text-[#FE9677] transition-colors hidden sm:block">
                Log in
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-bold uppercase tracking-widest text-[#0f1015] bg-gradient-to-r from-[#FE9677] to-[#F64668] hover:scale-105 transition-transform rounded-lg shadow-[0_0_15px_rgba(246,70,104,0.4)]">
                Register
            </a>
            @endif
            @endauth
        </div>
        @endif
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center px-6 relative overflow-hidden py-12">

        <div class="max-w-4xl w-full text-center z-10">
            <h1 class="text-5xl md:text-7xl font-black mb-6 uppercase tracking-[2px] leading-tight">
                Stress-Free <br />
                <span class="bg-gradient-to-r from-[#FE9677] to-[#F64668] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(246,70,104,0.3)]">
                    Shared Living
                </span>
            </h1>

            <p class="text-lg md:text-xl text-gray-400 mb-10 max-w-2xl mx-auto font-medium">
                The ultimate platform to track, split, and settle household expenses with your roommates.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                @auth
                <a href="{{ url('/dashboard') }}" class="px-8 py-4 text-sm font-black uppercase tracking-widest text-[#0f1015] bg-gradient-to-r from-[#FE9677] to-[#F64668] hover:scale-105 transition-all rounded-xl shadow-[0_0_20px_rgba(246,70,104,0.4)] w-full sm:w-auto text-center">
                    Go to Dashboard
                </a>
                @else
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-8 py-4 text-sm font-black uppercase tracking-widest text-[#0f1015] bg-gradient-to-r from-[#FE9677] to-[#F64668] hover:scale-105 transition-all rounded-xl shadow-[0_0_20px_rgba(246,70,104,0.4)] w-full sm:w-auto text-center">
                    Get Started
                </a>
                @endif
                <a href="{{ route('login') }}" class="px-8 py-4 text-sm font-black uppercase tracking-widest text-[#FE9677] bg-[#1e2030] hover:bg-[#26283b] border-2 border-[#FE9677]/30 hover:border-[#FE9677] transition-all rounded-xl w-full sm:w-auto text-center">
                    Log In
                </a>
                @endauth
            </div>

        </div>
    </main>

    <footer class="w-full text-center py-8 text-[10px] text-gray-500 font-black tracking-widest uppercase border-t border-[#41436A]/50 mt-auto">
        &copy; {{ date('Y') }} Built for peaceful living.
    </footer>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</body>

</html>