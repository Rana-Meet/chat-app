<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Chat') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|bricolage-grotesque:600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 lg:px-8">

            {{-- Top bar --}}
            <header class="flex h-20 items-center justify-between">
                <a href="/" class="flex items-center gap-2.5">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-ink text-white">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.6-.8L3 21l1.9-5.1A8.4 8.4 0 1 1 21 11.5Z"/></svg>
                    </span>
                    <span class="font-display text-lg font-semibold">{{ config('app.name', 'Chat') }}</span>
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-2">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center rounded-xl bg-brand px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="rounded-xl px-4 py-2.5 text-sm font-semibold text-ink-soft transition hover:bg-white hover:text-ink">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center rounded-xl bg-brand px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            {{-- Hero --}}
            <main class="grid flex-1 items-center gap-12 py-10 lg:grid-cols-[1.05fr_1fr] lg:gap-16 lg:py-16">

                <div>
                    <p class="inline-flex items-center gap-2 rounded-full bg-brand-tint px-3.5 py-1.5 text-sm font-semibold text-brand-dark">
                        <span class="h-2 w-2 rounded-full bg-signal"></span>
                        Real-time messaging
                    </p>

                    <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-6xl">
                        Say it once.<br>They see it now.
                    </h1>

                    <p class="mt-6 max-w-lg text-lg leading-relaxed text-ink-soft">
                        A private one-to-one chat where every message lands the moment you send it. No refreshing, no waiting.
                    </p>

                    <div class="mt-9 flex flex-wrap items-center gap-3">
                        @auth
                            <a href="{{ route('chat.index') }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-brand px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                                Open chat
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center gap-2 rounded-xl bg-brand px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                                    Create an account
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                </a>
                            @endif
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center rounded-xl border border-edge bg-white px-6 py-3.5 text-sm font-semibold text-ink transition hover:bg-mist">
                                Log in
                            </a>
                        @endauth
                    </div>

                    <ul class="mt-12 grid gap-5 sm:grid-cols-3">
                        <li>
                            <p class="font-display text-base font-semibold">Instant</p>
                            <p class="mt-1 text-sm leading-relaxed text-ink-soft">Delivered over websockets as you hit send.</p>
                        </li>
                        <li>
                            <p class="font-display text-base font-semibold">Private</p>
                            <p class="mt-1 text-sm leading-relaxed text-ink-soft">Each person gets their own secure channel.</p>
                        </li>
                        <li>
                            <p class="font-display text-base font-semibold">Anywhere</p>
                            <p class="mt-1 text-sm leading-relaxed text-ink-soft">Works on desktop and on your phone.</p>
                        </li>
                    </ul>
                </div>

                {{-- Chat preview --}}
                <div class="auth-aside relative overflow-hidden rounded-3xl p-6 shadow-panel sm:p-8" aria-hidden="true">
                    <div class="flex items-center gap-3 border-b border-white/10 pb-5">
                        <span class="grid h-10 w-10 place-items-center rounded-full bg-brand text-sm font-bold text-white">R</span>
                        <div>
                            <p class="font-display text-base font-semibold text-white">Riya</p>
                            <p class="flex items-center gap-1.5 text-xs text-white/60"><span class="h-1.5 w-1.5 rounded-full bg-signal"></span>Online</p>
                        </div>
                    </div>

                    <div class="space-y-3 py-8">
                        <div class="demo-bubble flex">
                            <div class="max-w-[80%] rounded-2xl rounded-bl-sm bg-white px-4 py-2.5 text-sm text-ink shadow-lg">Did the new design go live?</div>
                        </div>
                        <div class="demo-bubble flex justify-end">
                            <div class="max-w-[80%] rounded-2xl rounded-br-sm bg-brand px-4 py-2.5 text-sm text-white shadow-lg ring-1 ring-white/15">Yes! Refresh and take a look.</div>
                        </div>
                        <div class="demo-bubble flex">
                            <div class="max-w-[80%] rounded-2xl rounded-bl-sm bg-white px-4 py-2.5 text-sm text-ink shadow-lg">Love it. Sending feedback now.</div>
                        </div>
                        <div class="demo-bubble flex">
                            <div class="flex items-center gap-1.5 rounded-2xl rounded-bl-sm bg-white/10 px-4 py-3 ring-1 ring-white/15">
                                <span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/10">
                        <span class="flex-1 text-sm text-white/50">Write a message</span>
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-brand text-white">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7Z"/></svg>
                        </span>
                    </div>
                </div>
            </main>

            <footer class="py-8 text-sm text-ink-soft">
                &copy; {{ date('Y') }} {{ config('app.name', 'Chat') }}
            </footer>
        </div>
    </body>
</html>