<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-xl border border-edge bg-white px-5 py-3 text-sm font-semibold text-ink transition hover:bg-mist focus:outline-none focus-visible:ring-4 focus-visible:ring-brand/20 disabled:opacity-60']) }}>
    {{ $slot }}
</button>`..