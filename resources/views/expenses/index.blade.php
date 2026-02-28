<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#41436A] tracking-widest uppercase">
            Expense History
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e2030] border-2 border-[#984063] rounded-[22px] p-8 text-white">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-3xl font-bold">Settled Expenses</h3>
                        <p class="text-gray-400 text-sm mt-1">Past expenses that have been resolved.</p>
                    </div>
                    <div>
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white text-sm font-bold uppercase tracking-widest transition-all">&larr; Back to Dashboard</a>
                    </div>
                </div>

                @if($settledExpenses->isEmpty())
                <div class="bg-[#0f1015] border border-[#41436A] rounded-xl p-8 text-center mt-6">
                    <p class="text-gray-400 text-sm">No settled expenses yet.</p>
                </div>
                @else
                <div class="space-y-3 mt-8">
                    @foreach($settledExpenses as $expense)
                    <div class="flex justify-between items-center bg-[#0f1015] p-4 rounded-xl border border-[#41436A]">
                        <div class="flex flex-col">
                            <a href="{{ route('expenses.show', $expense->id) }}" class="text-gray-400 font-bold text-lg strike line-through hover:text-[#FE9677] transition-all">
                                {{ $expense->title }}
                            </a>
                            <span class="text-xs text-gray-500 mt-1">
                                Settled on {{ $expense->date->format('d M, Y') }}
                                &bull; Paid by {{ $expense->paidBy->name ?? 'Unknown' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-black text-gray-500">{{ number_format($expense->amount, 2) }} <span class="text-xs">DH</span></span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>