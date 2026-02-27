@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-[#26283b] border-[#41436A] focus:border-[#F64668] focus:ring-[#F64668] rounded-xl text-white shadow-sm']) }}>