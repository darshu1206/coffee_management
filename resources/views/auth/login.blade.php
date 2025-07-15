<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm" name="remember">
                <span class="ms-2 text-sm text-[#C6BFBC]">{{ __('Remember me') }}</span>
            </label>

                <a class="underline text-sm text-[#C6BFBC] hover:text-[#8E7A72] rounded-md" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button>
                {{ __('Login') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-4">
            <p class="text-sm text-[#C6BFBC] me-2">
                {{ __('Don\'t have an account?') }}
            </p>
            <a class="underline text-sm text-[#C6BFBC] hover:text-[#8E7A72] rounded-md" href="{{ route('register') }}">
                {{ __('Register here') }}
            </a>
        </div>
    </form>
</x-guest-layout>
