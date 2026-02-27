<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-[#41436A] tracking-widest uppercase">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-br from-[#41436A] to-[#984063] p-1">
                <div class="bg-[#1e2030] rounded-[22px] p-8 h-full">
                    <table class="min-w-full text-white">
                        <thead>
                            <tr class="border-b border-[#984063]/50 text-[#FE9677] text-xs uppercase tracking-widest">
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#984063]/20">
                            @foreach($users as $user)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-bold">{{ $user->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->is_banned ? 'bg-[#F64668]/20 text-[#F64668]' : 'bg-[#FE9677]/20 text-[#FE9677]' }}">
                                        {{ $user->is_banned ? 'Banned' : 'Active' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route($user->is_banned ? 'admin.users.unban' : 'admin.users.ban', $user) }}" method="POST">
                                        @csrf
                                        <button class="font-black text-xs uppercase tracking-tighter {{ $user->is_banned ? 'text-white' : 'text-[#F64668]' }}">
                                            {{ $user->is_banned ? 'Restore User' : 'Ban User' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>