@props(['active'])

@php
$classes = ($active ?? false)
? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#FE9677] text-sm font-black uppercase tracking-widest text-[#FE9677] focus:outline-none transition duration-150 ease-in-out'
: 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-black uppercase tracking-widest text-gray-400 hover:text-white hover:border-[#F64668] focus:outline-none focus:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>