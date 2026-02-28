<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#41436A] tracking-widest uppercase">
            Expense Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e2030] border-2 border-[#984063] rounded-[22px] p-10 text-white shadow-2xl">

                <div class="flex justify-between items-start mb-8 border-b border-[#41436A] pb-6">
                    <div>
                        <h3 class="text-4xl font-bold mb-2">{{ $expense->title }}</h3>
                        <p class="text-gray-400 text-sm">
                            Logged on {{ $expense->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-black text-[#FE9677]">{{ number_format($expense->amount, 2) }} <span class="text-sm">DH</span></span>
                        <span class="block text-xs text-gray-400 uppercase tracking-widest mt-1">Total Cost</span>
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-sm font-black text-[#FE9677] uppercase tracking-widest mb-4">How it splits ({{ number_format($splitAmount, 2) }} DH each)</h4>

                    <div class="space-y-3">
                        @foreach($members as $member)
                        <div class="flex justify-between items-center bg-[#0f1015] p-4 rounded-xl border {{ ($member->id === $expense->paid_by || in_array($member->id, $settledUserIds)) ? 'border-green-500/50' : 'border-[#41436A]' }}">
                            <div>
                                <p class="text-white font-bold">{{ $member->name }} {{ $member->id === Auth::id() ? '(You)' : '' }}</p>
                            </div>
                            <div class="text-right flex items-center gap-4">
                                @if($member->id === $expense->paid_by)
                                <span class="text-green-400 font-black text-sm uppercase tracking-widest">Paid the bill</span>
                                @elseif(in_array($member->id, $settledUserIds))
                                <span class="text-green-400 font-black text-sm uppercase tracking-widest">Paid</span>
                                @else
                                <div class="flex flex-col items-end text-right">
                                    <span class="text-[#F64668] font-black text-lg">{{ number_format($splitAmount, 2) }} <span class="text-xs">DH</span></span>
                                    <span class="block text-[10px] text-gray-500 uppercase tracking-widest">Owes {{ $expense->paidBy->name }}</span>
                                </div>

                                @if(Auth::id() === $expense->paid_by && is_null($expense->date))
                                <form method="POST" action="{{ route('expenses.mark_paid', ['expense' => $expense->id, 'user' => $member->id]) }}" class="ml-4 border-l border-[#41436A] pl-4">
                                    @csrf
                                    <button type="submit" class="text-[#FE9677] hover:text-white hover:bg-[#FE9677] px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all border border-[#FE9677]">
                                        Mark as Paid
                                    </button>
                                </form>
                                @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between items-center pt-6 border-t border-[#41436A]">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white text-sm font-bold uppercase tracking-widest transition-all">&larr; Back to Dashboard</a>

                    @if(is_null($expense->date))
                    @if(Auth::id() === $expense->paid_by)
                    <form method="POST" action="{{ route('expenses.settle', $expense->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-6 py-3 bg-green-500/20 border-2 border-green-500 text-green-400 hover:bg-green-500 hover:text-white font-black rounded-xl uppercase tracking-widest transition-all">
                            Mark as Settled
                        </button>
                    </form>
                    @else
                    <span class="px-6 py-3 bg-gray-500/10 border-2 border-gray-500/50 text-gray-500 font-black rounded-xl uppercase tracking-widest">
                        Pending
                    </span>
                    @endif
                    @else
                    <span class="px-6 py-3 bg-[#0f1015] border-2 border-[#41436A] text-gray-500 font-black rounded-xl uppercase tracking-widest">
                        Settled on {{ $expense->date->format('M d, Y') }}
                    </span>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>