<section>
    <header>
        <h2 class="text-xl font-black text-white uppercase tracking-widest">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-xs font-bold text-gray-400 uppercase tracking-widest">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" class="text-[#FE9677] text-xs font-black uppercase tracking-widest" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all font-bold" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[#F64668]" />
        </div>

        <div>
            <x-input-label for="update_password_password" class="text-[#FE9677] text-xs font-black uppercase tracking-widest" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[#F64668]" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" class="text-[#FE9677] text-xs font-black uppercase tracking-widest" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[#F64668]" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#F64668] to-[#FE9677] text-white font-black rounded-full uppercase tracking-widest shadow-lg hover:scale-105 transition-all">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-xs font-black text-[#FE9677] uppercase tracking-widest">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>