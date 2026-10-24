<x-guest-layout>
    <h1 class="text-3xl font-bold">Welcome back</h1>
    <p class="mt-2 text-ink-soft">Log in to continue your conversations.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="loginForm" class="mt-8 space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="link-quiet" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                @endif
            </div>

            <div class="relative mt-1.5">
                <x-text-input id="password" class="pr-16"
                              type="password" x-bind:type="show ? 'text' : 'password'"
                              name="password" required autocomplete="current-password" placeholder="Your password" />
                <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 px-4 text-sm font-semibold text-ink-soft hover:text-ink"
                        x-text="show ? 'Hide' : 'Show'">Show</button>
            </div>

            <p id="capsHint" class="mt-2 hidden text-sm font-medium text-ink-soft" role="status">Caps Lock is on.</p>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                   class="h-4 w-4 rounded border-edge text-brand focus:ring-brand/30">
            <span class="text-sm text-ink-soft">{{ __('Remember me') }}</span>
        </label>

        <x-primary-button class="w-full" id="loginBtn">
            <svg id="loginSpinner" class="hidden h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" opacity=".3"/>
                <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <span id="loginLabel">{{ __('Log in') }}</span>
        </x-primary-button>
    </form>

    @if (Route::has('register'))
        <p class="mt-8 text-center text-sm text-ink-soft">
            New here?
            <a class="link-quiet" href="{{ route('register') }}">Create an account</a>
        </p>
    @endif

    {{-- UI helpers only: the form still posts exactly as before --}}
    <script>
        (function () {
            const form    = document.getElementById('loginForm');
            const btn     = document.getElementById('loginBtn');
            const spinner = document.getElementById('loginSpinner');
            const label   = document.getElementById('loginLabel');
            const pass    = document.getElementById('password');
            const caps    = document.getElementById('capsHint');

            // Warn when Caps Lock is on while typing the password
            function checkCaps(e) {
                if (typeof e.getModifierState !== 'function') return;
                caps.classList.toggle('hidden', !e.getModifierState('CapsLock'));
            }
            pass.addEventListener('keydown', checkCaps);
            pass.addEventListener('keyup', checkCaps);
            pass.addEventListener('blur', () => caps.classList.add('hidden'));

            // Show a "Logging in…" state after submit so it can't be clicked twice
            form.addEventListener('submit', () => {
                // let the browser submit first, then lock the button
                setTimeout(() => {
                    btn.setAttribute('aria-busy', 'true');
                    btn.classList.add('opacity-70', 'pointer-events-none');
                    spinner.classList.remove('hidden');
                    label.textContent = 'Logging in…';
                }, 0);
            });

            // Restore the button if the page comes back from the browser's back button
            window.addEventListener('pageshow', e => {
                if (e.persisted) {
                    btn.removeAttribute('aria-busy');
                    btn.classList.remove('opacity-70', 'pointer-events-none');
                    spinner.classList.add('hidden');
                    label.textContent = @json(__('Log in'));
                }
            });
        })();
    </script>
</x-guest-layout>