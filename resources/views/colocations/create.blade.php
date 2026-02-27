<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white tracking-widest uppercase">Setup House</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e2030] border-2 border-[#984063] rounded-[22px] p-8 text-white shadow-2xl">
                <form method="POST" action="{{ route('colocations.store') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-[#FE9677] text-xs font-black uppercase mb-2">House Name</label>
                        <input type="text" name="name" required class="w-full bg-[#26283b] border-[#41436A] rounded-xl text-white">
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-[#F64668] to-[#FE9677] font-black rounded-full uppercase tracking-widest hover:scale-105 transition-transform">
                        Establish Colocation
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>