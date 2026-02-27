<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#41436A] tracking-widest uppercase">
            Log New Expense
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e2030] border-2 border-[#984063] rounded-[22px] p-10 text-white shadow-2xl">
                
                <form method="POST" action="{{ route('expenses.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-[#FE9677] text-xs font-black uppercase tracking-widest mb-2">What did you pay for?</label>
                        <input type="text" name="title" required placeholder="Groceries, Internet Bill.... "
                            class="w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all">
                        @error('title') <span class="text-[#F64668] text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-[#FE9677] text-xs font-black uppercase tracking-widest mb-2">Amount (DH)</label>
                            <input type="number" step="0.01" name="amount" required placeholder="0.00"
                                class="w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all">
                            @error('amount') <span class="text-[#F64668] text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[#FE9677] text-xs font-black uppercase tracking-widest mb-2">Date Paid</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                                class="w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all">
                            @error('date') <span class="text-[#F64668] text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-6 border-t border-[#41436A]">
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white text-sm font-bold uppercase tracking-widest transition-all">Cancel</a>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-[#F64668] to-[#FE9677] text-white font-black rounded-full uppercase tracking-widest shadow-lg hover:scale-105 transition-all">
                            Save Expense
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>