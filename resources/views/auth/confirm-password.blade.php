@section('title', $data['title'] ?? 'Login' . ' | ' . config('app.name'))
@section('meta_description', '')

<x-guest-layout>
    <div class="mx-auto flex h-screen w-full flex-col overflow-hidden bg-white p-2 md:flex-row">
        <!-- Left Side - Image and Quote -->
        <div class="relative hidden md:block md:w-1/2">
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-bl from-[#84cc16] via-[#16a34a] to-[#0f766e] opacity-80"></div>
            <img class="h-full w-full rounded-3xl object-cover" src="https://placehold.co/600x800/1a1a1a/ffffff?text=Abstract+Design" alt="Background">

            <div class="absolute inset-0 flex flex-col justify-between p-8 text-white">
                <div class="text-sm font-medium uppercase tracking-wider">
                    <span class="inline-block">{{ __('Confirm Password') }}</span>
                    <span class="ml-2 inline-block h-1 w-16 bg-white opacity-50"></span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-2xl font-bold leading-tight md:text-3xl">
                        {{ __('Login') }}
                    </h1>
                    <p class="max-w-xs text-sm opacity-90">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex flex-col justify-center p-8 md:w-1/2 md:p-12">
            <div class="mb-10 flex items-center text-xl">
                <a class="flex items-end space-x-2" href="/">
                    <x-application-logo class="h-12 w-12 fill-current text-gray-500" />
                    <span class="text-primary text-2xl font-semibold">{{ config('app.name') }}</span>
                </a>
            </div>

            <div class="mb-8">
                <h2 class="text-base-content mb-2 text-3xl font-bold md:text-4xl">{{ __('Welcome Back') }}</h2>
                <p class="text-base-content-muted">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form class="space-y-3 md:space-y-4" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input class="mt-1 block w-full" id="password" name="password" type="password" required autocomplete="current-password" />

                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <x-button-primary class="w-full" type="submit">
                    {{ __('Confirm') }}
                </x-button-primary>

            </form>
        </div>
    </div>
</x-guest-layout>
