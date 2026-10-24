@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-xl border-edge bg-white px-4 py-3 text-[15px] text-ink shadow-none placeholder:text-ink/40 focus:border-brand focus:ring-4 focus:ring-brand/15 disabled:bg-mist disabled:text-ink/50']) }}>