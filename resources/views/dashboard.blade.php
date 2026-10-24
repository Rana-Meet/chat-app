<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold">Hi, {{ Auth::user()->name }}</h1>
        <p class="mt-1.5 text-ink-soft">You're signed in. Pick up where you left off.</p>
    </x-slot>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">

            {{-- Main action --}}
            <a href="{{ route('chat.index') }}"
               class="auth-aside group relative flex min-h-[280px] flex-col justify-between overflow-hidden rounded-3xl p-8 text-white shadow-panel">
                <div class="space-y-2.5" aria-hidden="true">
                    <div class="flex"><span class="rounded-2xl rounded-bl-sm bg-white px-4 py-2 text-sm text-ink">Free for a quick call?</span></div>
                    <div class="flex justify-end"><span class="rounded-2xl rounded-br-sm bg-brand px-4 py-2 text-sm ring-1 ring-white/15">Give me five minutes.</span></div>
                </div>

                <div class="mt-10 flex items-end justify-between gap-4">
                    <div>
                        <h2 class="font-display text-2xl font-bold">Open chat</h2>
                        <p class="mt-1 text-white/70">See who's there and send a message.</p>
                    </div>
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-white text-ink transition group-hover:bg-brand-tint">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </span>
                </div>
            </a>

            {{-- Shortcuts --}}
            <div class="panel divide-y divide-edge self-start overflow-hidden">
                <a href="{{ route('user.create') }}" class="flex items-center gap-4 p-5 transition hover:bg-mist">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-tint text-brand-dark">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg>
                    </span>
                    <span>
                        <span class="block font-semibold">Add a user</span>
                        <span class="block text-sm text-ink-soft">Create an account for someone new.</span>
                    </span>
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 p-5 transition hover:bg-mist">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-tint text-brand-dark">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                    </span>
                    <span>
                        <span class="block font-semibold">Your profile</span>
                        <span class="block text-sm text-ink-soft">Change your name, email or password.</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>