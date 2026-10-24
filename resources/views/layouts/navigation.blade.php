<nav x-data="{ open: false, menu: false }" class="border-b border-edge bg-white">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-8">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-ink text-white">
                    <svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.6-.8L3 21l1.9-5.1A8.4 8.4 0 1 1 21 11.5Z"/></svg>
                </span>
                <span class="font-display text-base font-semibold">{{ config('app.name', 'Chat') }}</span>
            </a>

            <!-- Links -->
            <div class="hidden items-center gap-1 sm:flex">
                <a href="{{ route('dashboard') }}"
                   class="rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-brand-tint text-brand-dark' : 'text-ink-soft hover:bg-mist hover:text-ink' }}">
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('chat.index') }}"
                   class="rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('chat.*') ? 'bg-brand-tint text-brand-dark' : 'text-ink-soft hover:bg-mist hover:text-ink' }}">
                    Chat
                </a>
            </div>
        </div>

        <!-- Account menu -->
        <div class="relative hidden sm:block" @click.outside="menu = false" @keydown.escape.window="menu = false">
            <button type="button" @click="menu = !menu" :aria-expanded="menu"
                    class="flex items-center gap-2.5 rounded-full py-1.5 pl-1.5 pr-3 transition hover:bg-mist">
                <span class="grid h-8 w-8 place-items-center rounded-full bg-brand text-sm font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                <svg class="h-4 w-4 text-ink-soft" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.3 7.3a1 1 0 0 1 1.4 0L10 10.6l3.3-3.3a1 1 0 1 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 0-1.4Z" clip-rule="evenodd"/></svg>
            </button>

            <div x-show="menu" x-cloak x-transition.opacity.duration.100ms
                 class="panel absolute right-0 z-20 mt-2 w-52 overflow-hidden p-1.5">
                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm font-medium hover:bg-mist">{{ __('Profile') }}</a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-alert hover:bg-mist">{{ __('Log Out') }}</button>
                </form>
            </div>
        </div>

        <!-- Hamburger -->
        <button type="button" @click="open = !open" :aria-expanded="open" aria-label="Menu"
                class="grid h-10 w-10 place-items-center rounded-lg text-ink-soft hover:bg-mist sm:hidden">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path x-show="!open" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="open" x-cloak d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Responsive menu -->
    <div x-show="open" x-cloak class="border-t border-edge sm:hidden">
        <div class="space-y-1 px-4 py-3">
            <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-brand-tint text-brand-dark' : 'text-ink-soft' }}">{{ __('Dashboard') }}</a>
            <a href="{{ route('chat.index') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('chat.*') ? 'bg-brand-tint text-brand-dark' : 'text-ink-soft' }}">Chat</a>
        </div>

        <div class="border-t border-edge px-4 py-3">
            <div class="px-3">
                <div class="text-sm font-semibold">{{ Auth::user()->name }}</div>
                <div class="text-sm text-ink-soft">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-ink-soft">{{ __('Profile') }}</a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-alert">{{ __('Log Out') }}</button>
                </form>
            </div>
        </div>
    </div>
</nav>