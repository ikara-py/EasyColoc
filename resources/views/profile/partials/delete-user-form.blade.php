<section class="space-y-6">
    <header>
        <h2 class="text-xl font-black text-[#F64668] uppercase tracking-widest">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-8 py-3 bg-transparent border-2 border-[#F64668] text-[#F64668] font-black rounded-full uppercase tracking-widest hover:bg-[#F64668] hover:text-white transition-all shadow-lg shadow-[#F64668]/20">{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-[#1e2030] border-2 border-[#984063]">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-[#F64668] uppercase tracking-widest mb-4">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#F64668] focus:ring-0 transition-all font-bold placeholder-gray-600"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[#F64668]" />
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-transparent border-2 border-[#41436A] text-gray-400 font-black rounded-xl uppercase tracking-widest hover:text-white transition-all w-full">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-6 py-3 bg-[#F64668] text-white font-black rounded-xl uppercase tracking-widest hover:scale-105 transition-all shadow-lg shadow-[#F64668]/20 w-full">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>