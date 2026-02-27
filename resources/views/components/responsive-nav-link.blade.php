@props(['active'])

@php
$classes = ($active ?? false)
? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#FE9677] text-start text-base font-black uppercase tracking-widest text-[#FE9677] bg-[#26283b] focus:outline-none transition duration-150 ease-in-out'
: 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-black uppercase tracking-widest text-gray-400 hover:text-white hover:bg-[#26283b] hover:border-[#F64668] focus:outline-none focus:text-white focus:bg-[#26283b] focus:border-[#F64668] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>