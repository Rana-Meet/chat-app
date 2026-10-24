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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="grid min-h-screen lg:grid-cols-[minmax(0,1fr)_minmax(0,1.1fr)]">

            {{-- Left: brand + live conversation preview (desktop only) --}}
            <aside class="auth-aside relative hidden flex-col justify-between overflow-hidden p-12 text-white lg:flex">
                <a href="/" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/10 ring-1 ring-white/20">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.6-.8L3 21l1.9-5.1A8.4 8.4 0 1 1 21 11.5Z"/></svg>
                    </span>
                    <span class="font-display text-lg font-semibold">{{ config('app.name', 'Chat') }}</span>
                </a>

                <div class="max-w-md">
                    <h2 class="font-display text-4xl font-bold leading-tight">Messages arrive the moment they're sent.</h2>
                    <p class="mt-4 text-base leading-relaxed text-white/70">Sign in, pick a person, and talk. No refreshing, no waiting.</p>

                    <div class="mt-10 space-y-3" aria-hidden="true">
                        <div class="demo-bubble flex">
                            <div class="rounded-2xl rounded-bl-sm bg-white px-4 py-2.5 text-sm text-ink shadow-lg">Is the build live yet?</div>
                        </div>
                        <div class="demo-bubble flex justify-end">
                            <div class="rounded-2xl rounded-br-sm bg-brand px-4 py-2.5 text-sm text-white shadow-lg ring-1 ring-white/15">Just pushed it. Check now.</div>
                        </div>
                        <div class="demo-bubble flex">
                            <div class="flex items-center gap-1.5 rounded-2xl rounded-bl-sm bg-white/10 px-4 py-3 ring-1 ring-white/15">
                                <span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-sm text-white/50">&copy; {{ date('Y') }} {{ config('app.name', 'Chat') }}</p>
            </aside>

            {{-- Right: the form --}}
            <main class="flex items-center justify-center px-6 py-12 sm:px-12">
                <div class="w-full max-w-md">
                    <a href="/" class="mb-10 flex items-center gap-3 lg:hidden">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-ink text-white">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.6-.8L3 21l1.9-5.1A8.4 8.4 0 1 1 21 11.5Z"/></svg>
                        </span>
                        <span class="font-display text-lg font-semibold">{{ config('app.name', 'Chat') }}</span>
                    </a>

                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>