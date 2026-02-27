<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#41436A] tracking-widest uppercase">
            {{ __('Command Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-br from-[#41436A] to-[#984063] p-1">
                <div class="bg-[#1e2030] rounded-[22px] p-8 h-full">

                    <div class="flex justify-between items-center mb-10 border-b border-[#984063]/30 pb-4">
                        <h3 class="text-3xl font-extrabold text-white tracking-tight">
                            Platform <span class="text-[#FE9677]">Pulse</span>
                        </h3>
                        <a href="{{ route('admin.users') }}" class="group relative px-6 py-2 font-bold text-white rounded-full bg-gradient-to-r from-[#984063] to-[#F64668] hover:shadow-[0_0_20px_rgba(246,70,104,0.6)] transition-all duration-300 transform hover:-translate-y-1">
                            Manage Users
                            <span class="absolute inset-0 h-full w-full rounded-full border-2 border-white/20 group-hover:border-white/50 transition-colors"></span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#41436A] to-[#984063] p-6 shadow-lg transform transition duration-300 hover:scale-105 group">
                            <span class="block text-white/70 text-xs uppercase tracking-widest font-bold mb-2">Total Users</span>
                            <span class="text-5xl font-black text-white drop-shadow-md">{{ $totalUsers }}</span>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#984063] to-[#F64668] p-6 shadow-lg transform transition duration-300 hover:scale-105 group">
                            <span class="block text-white/70 text-xs uppercase tracking-widest font-bold mb-2">Colocations</span>
                            <span class="text-5xl font-black text-white drop-shadow-md">{{ $totalColocations }}</span>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#F64668] to-[#FE9677] p-6 shadow-lg transform transition duration-300 hover:scale-105 group">
                            <span class="block text-white/90 text-xs uppercase tracking-widest font-bold mb-2">Banned Users</span>
                            <span class="text-5xl font-black text-white drop-shadow-md">{{ $bannedUsers }}</span>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl bg-[#26283b] border border-[#FE9677]/40 p-6 shadow-lg transform transition duration-300 hover:scale-105 group">
                            <span class="block text-[#FE9677] text-xs uppercase tracking-widest font-bold mb-2">Total Expenses</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-bold text-[#FE9677]">$</span>
                                <span class="text-5xl font-black text-white drop-shadow-md">{{ $totalExpenses }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>