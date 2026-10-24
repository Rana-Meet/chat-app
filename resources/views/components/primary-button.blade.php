<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-4 focus-visible:ring-brand/30 disabled:opacity-60']) }}>
    {{ $slot }}
</button>