<x-guest-layout>
    <h1 class="text-3xl font-bold">Create your account</h1>
    <p class="mt-2 text-ink-soft">It takes a minute. Then you can start chatting.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-1.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5"
                          type="password"
                          name="password"
                          required autocomplete="new-password" placeholder="Choose a password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1.5"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" placeholder="Type it again" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">{{ __('Register') }}</x-primary-button>
    </form>

    <p class="mt-8 text-center text-sm text-ink-soft">
        Already registered?
        <a class="link-quiet" href="{{ route('login') }}">Log in</a>
    </p>
</x-guest-layout>