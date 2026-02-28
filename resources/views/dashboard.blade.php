<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#41436A] tracking-widest uppercase">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-6 bg-green-500/20 border border-green-500 text-green-200 px-4 py-3 rounded-xl shadow-lg">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="mb-6 bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-xl shadow-lg">
                {{ session('error') }}
            </div>
            @endif

            @php
            $colocation = Auth::user()->colocations()->where('colocations.status', 'active')->first();
            @endphp

            @if($colocation)
            <div class="bg-[#1e2030] border-2 border-[#984063] rounded-[22px] p-8 text-white">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-3xl font-bold">{{ $colocation->name }}</h3>
                        <p class="text-[#FE9677] uppercase text-xs font-black tracking-widest">Role: {{ $colocation->pivot->group_role }}</p>
                    </div>
                </div>

                <div class="border-t border-[#41436A] pt-6 mt-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-black text-[#FE9677] uppercase tracking-widest">Active Expenses</h4>
                        <a href="{{ route('expenses.create') }}" class="px-4 py-2 bg-[#26283b] border border-[#FE9677] text-[#FE9677] text-xs font-black rounded-lg uppercase tracking-widest hover:bg-[#FE9677] hover:text-[#1e2030] transition-all whitespace-nowrap">
                            + Log Expense
                        </a>
                    </div>

                    @php
                    $activeExpenses = $colocation->expenses()->whereNull('date')->with('paidBy')->orderBy('created_at', 'desc')->get();

                    $settledExpenses = $colocation->expenses()->whereNotNull('date')->with('paidBy')->orderBy('date', 'desc')->get();
                    @endphp

                    @if($activeExpenses->isEmpty())
                    <div class="bg-[#0f1015] border border-[#41436A] rounded-xl p-8 text-center mb-6">
                        <p class="text-gray-400 text-sm">No active expenses.</p>
                    </div>
                    @else
                    <div class="space-y-3 mb-8">
                        @foreach($activeExpenses as $expense)
                        <a href="{{ route('expenses.show', $expense->id) }}" class="flex justify-between items-center bg-[#0f1015] p-4 rounded-xl border border-[#FE9677] shadow-lg hover:bg-[#1e2030] transition-all cursor-pointer block">
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-lg hover:text-[#FE9677] transition-all">
                                    {{ $expense->title }}
                                </span>
                                <span class="text-xs text-gray-400 mt-1">
                                    Paid by <span class="text-[#FE9677] font-bold">{{ $expense->paidBy->name ?? 'Unknown' }}</span> on {{ $expense->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="text-right flex items-center gap-4">
                                <span class="text-xl font-black text-white">{{ number_format($expense->amount, 2) }} <span class="text-xs text-[#FE9677]">DH</span></span>

                                @if(Auth::id() === $expense->paid_by)
                                <form method="POST" action="{{ route('expenses.settle', $expense->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-400 hover:text-white hover:bg-green-500 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all border border-green-500 relative z-10">
                                        Settle
                                    </button>
                                </form>
                                @else
                                <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest border border-gray-600 px-3 py-1 rounded-lg">
                                    Pending
                                </span>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-4 mt-8 pt-6 border-t border-[#41436A]">
                        <h4 class="text-sm font-black text-gray-500 uppercase tracking-widest">Settled History</h4>
                        <a href="{{ route('expenses.index') }}" class="px-4 py-2 bg-transparent border border-gray-500 text-gray-400 text-xs font-black rounded-lg uppercase tracking-widest hover:text-white hover:border-white transition-all whitespace-nowrap">
                            View History
                        </a>
                    </div>
                </div>
                <div class="border-t border-[#41436A] pt-6 mt-2 mb-6">
                    <h4 class="text-sm font-black text-[#FE9677] uppercase tracking-widest mb-4">House Members</h4>
                    <div class="space-y-3">
                        @foreach($colocation->users as $member)
                        <div class="flex justify-between items-center bg-[#0f1015] p-4 rounded-xl border {{ $member->pivot->left_at ? 'border-gray-700 opacity-60' : 'border-[#41436A]' }}">
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="text-white font-bold">
                                        {{ $member->name }}
                                        @if($member->pivot->left_at)
                                        <span class="text-xs text-gray-500 italic ml-2">(Left)</span>
                                        @endif
                                    </p>
                                    @php
                                    $repColor = $member->reputation_score > 0 ? 'text-green-400' : ($member->reputation_score < 0 ? 'text-[#F64668]' : 'text-gray-400' );
                                        @endphp
                                        <span class="{{ $repColor }} text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border border-current">
                                        Rep: {{ $member->reputation_score > 0 ? '+' : '' }}{{ $member->reputation_score }}
                                        </span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">{{ $member->email }}</p>
                            </div>
                            <div class="flex items-center gap-6">
                                @php
                                $balance = $colocation->getUserBalance($member->id);
                                $owedAmount = max(0, -$balance);
                                @endphp

                                <div class="text-right">
                                    @if($owedAmount > 0)
                                    <span class="text-[#F64668] font-black text-sm">{{ number_format($owedAmount, 2) }} DH</span>
                                    <span class="block text-[10px] text-gray-500 uppercase tracking-widest">Owes</span>
                                    @else
                                    <span class="text-gray-400 font-black text-sm">0.00 DH</span>
                                    <span class="block text-[10px] text-gray-500 uppercase tracking-widest">Settled</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-4 border-l border-[#41436A] pl-6">
                                    <span class="text-xs uppercase font-black tracking-widest {{ $member->pivot->group_role === 'owner' ? 'text-[#FE9677]' : 'text-gray-400' }}">
                                        {{ $member->pivot->group_role }}
                                    </span>

                                    @if($colocation->pivot->group_role === 'owner' && $member->id !== Auth::id() && !$member->pivot->left_at)
                                    <form method="POST" action="{{ route('colocations.remove_member', $member->id) }}" class="form-confirm" data-message="Are you sure you want to kick {{ $member->name }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[#F64668] hover:text-white hover:bg-[#F64668] px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all border border-[#F64668]">
                                            Kick
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($colocation->pivot->group_role === 'owner')
                <div class="border-t border-[#41436A] pt-6 mt-2 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-black text-[#FE9677] uppercase tracking-widest mb-1">Invite a Roommate</h4>
                        <p class="text-xs text-gray-400">Generate a unique, single-use join code.</p>
                    </div>

                    <form method="POST" action="{{ route('colocations.generate_invite') }}">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-[#26283b] border-2 border-[#FE9677] text-[#FE9677] font-black rounded-xl uppercase tracking-widest hover:bg-[#FE9677] hover:text-[#1e2030] transition-all whitespace-nowrap">
                            Generate Code
                        </button>
                    </form>
                </div>

                <div class="border-t border-[#41436A] pt-6 mt-6 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-black text-[#F64668] uppercase tracking-widest mb-1">Danger Zone</h4>
                        <p class="text-xs text-gray-400">Delete this house (only works if you are the only member).</p>
                    </div>

                    <form method="POST" action="{{ route('colocations.deactivate') }}" class="form-confirm" data-message="Are you sure you want to delete this house? This cannot be undone.">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-3 bg-transparent border-2 border-[#F64668] text-[#F64668] font-black rounded-xl uppercase tracking-widest hover:bg-[#F64668] hover:text-white transition-all whitespace-nowrap">
                            Delete House
                        </button>
                    </form>
                </div>
                @endif

                @if($colocation->pivot->group_role === 'member')
                <div class="border-t border-[#41436A] pt-6 mt-6 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-black text-[#F64668] uppercase tracking-widest mb-1">Danger Zone</h4>
                        <p class="text-xs text-gray-400">Leave this house permanently.</p>
                    </div>

                    <form method="POST" action="{{ route('colocations.leave') }}" class="form-confirm" data-message="Are you sure you want to leave this house? You will lose access to all expense records.">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-3 bg-transparent border-2 border-[#F64668] text-[#F64668] font-black rounded-xl uppercase tracking-widest hover:bg-[#F64668] hover:text-white transition-all whitespace-nowrap">
                            Leave House
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-[#1e2030] border-2 border-[#41436A] rounded-[22px] p-12 text-center text-white">
                    <h3 class="text-2xl font-black mb-4 uppercase">Establish Your House</h3>
                    <p class="text-gray-400 mb-8">Ready to track expenses? Create a house to get started.</p>
                    <a href="{{ route('colocations.create') }}"
                        class="inline-block px-8 py-3 bg-gradient-to-r from-[#F64668] to-[#FE9677] font-black rounded-full uppercase tracking-widest hover:scale-105 transition-all shadow-lg shadow-[#F64668]/20">
                        Create a House
                    </a>
                </div>

                <div class="bg-[#1e2030] border-2 border-[#984063] rounded-[22px] p-12 text-center text-white">
                    <h3 class="text-2xl font-black mb-4 uppercase">Join a House</h3>
                    <p class="text-gray-400 mb-8">Have a unique invite code from your roommate?</p>
                    <form method="POST" action="{{ route('colocations.join') }}" class="flex flex-col items-center">
                        @csrf
                        <input type="text" name="join_code" required placeholder="8-CHAR CODE" maxlength="8"
                            class="w-full max-w-xs bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-center text-white font-black tracking-widest uppercase focus:border-[#FE9677] focus:ring-0 transition-all mb-4">
                        @error('join_code')
                        <span class="text-[#F64668] text-xs font-bold mb-4 block">{{ $message }}</span>
                        @enderror
                        <button type="submit"
                            class="px-8 py-3 bg-transparent border-2 border-[#FE9677] text-[#FE9677] font-black rounded-full uppercase tracking-widest hover:bg-[#FE9677] hover:text-[#1e2030] transition-all">
                            Join House
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>