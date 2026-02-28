<section>
    <header>
        <h2 class="text-xl font-black text-white uppercase tracking-widest">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-xs font-bold text-gray-400 uppercase tracking-widest">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" class="text-[#FE9677] text-xs font-black uppercase tracking-widest" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all font-bold" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-[#F64668]" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" class="text-[#FE9677] text-xs font-black uppercase tracking-widest" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-[#0f1015] border-2 border-[#41436A] rounded-xl px-4 py-3 text-white focus:border-[#FE9677] focus:ring-0 transition-all font-bold" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-[#F64668]" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-xs mt-2 text-gray-400 font-bold uppercase tracking-widest">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-[#FE9677] hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FE9677] transition-all ml-2">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-[#41436A]">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#F64668] to-[#FE9677] text-white font-black rounded-full uppercase tracking-widest shadow-lg hover:scale-105 transition-all">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
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