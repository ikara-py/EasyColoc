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

                    <div class="mb-6">
                        <label class="block text-[#FE9677] text-xs font-black uppercase tracking-widest mb-2">Category</label>
                        <div class="flex gap-4">
                            <select name="category_id" required class="flex-1 bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all">
                                <option value="" disabled selected>Select a Category...</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <button type="button" id="btn-open-category-modal" class="px-6 py-3 bg-[#26283b] border border-[#FE9677] text-[#FE9677] text-xs font-black rounded-xl uppercase tracking-widest hover:bg-[#FE9677] hover:text-[#1e2030] transition-all whitespace-nowrap">
                                + New
                            </button>
                        </div>
                        @error('category_id') <span class="text-[#F64668] text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-[#FE9677] text-xs font-black uppercase tracking-widest mb-2">Amount (DH)</label>
                            <input type="number" step="0.01" name="amount" required placeholder="0.00"
                                class="w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all">
                            @error('amount') <span class="text-[#F64668] text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
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

    <div id="new-category-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center hidden z-50">
        <div class="bg-[#1e2030] border-2 border-[#984063] rounded-[22px] p-8 w-full max-w-sm">
            <h3 class="text-2xl font-bold text-white mb-4">New Category</h3>
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-[#FE9677] text-xs font-black uppercase tracking-widest mb-2">Category Name</label>
                    <input type="text" name="name" required placeholder="Rent, Utilities..."
                        class="w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all">
                </div>
                <div class="flex justify-between items-center gap-4">
                    <button type="button" id="btn-close-category-modal" class="px-6 py-3 bg-transparent border-2 border-[#41436A] text-gray-400 font-black rounded-xl uppercase tracking-widest hover:text-white transition-all w-full">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#F64668] to-[#FE9677] text-white font-black rounded-xl uppercase tracking-widest hover:scale-105 transition-all shadow-lg shadow-[#F64668]/20 w-full">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>