@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[#FE9677] text-xs font-black uppercase mb-2']) }}>
    {{ $value ?? $slot }}
</label>