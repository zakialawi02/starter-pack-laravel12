@section('title', $data['title'] ?? 'Forgot Password' . ' | ' . config('app.name'))
@section('meta_description', '')

<x-guest-layout>
    <div class="mx-auto flex h-screen w-full flex-col overflow-hidden bg-white p-2 md:flex-row">
        <!-- Left Side - Image and Quote -->
        <div class="relative hidden md:block md:w-1/2">
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-bl from-[#84cc16] via-[#16a34a] to-[#0f766e] opacity-80"></div>
            <img class="h-full w-full rounded-3xl object-cover" src="{{ asset('assets/img/image-placeholder.png') }}" alt="Background">

            <div class="absolute inset-0 flex flex-col justify-between p-8 text-white">
                <div class="text-sm font-medium uppercase tracking-wider">
                    <span class="inline-block">{{ __('Password Recovery') }}</span>
                    <span class="ml-2 inline-block h-1 w-16 bg-white opacity-50"></span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-2xl font-bold leading-tight md:text-3xl">
                        {{ __('Reset Your Password') }}
                    </h1>
                    <p class="max-w-xs text-sm opacity-90">
                        {{ __('Enter your email address and we\'ll send you a link to reset your password.') }}
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
                <h2 class="text-base-content mb-2 text-3xl font-bold md:text-4xl">{{ __('Forgot Password?') }}</h2>
                <p class="text-base-content-muted">{{ __('Enter your email address and we\'ll send you a link to reset your password.') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />


            <form class="space-y-3 md:space-y-4" method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" placeholder="name@mail.com" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <x-button-primary class="w-full" type="submit">
                    {{ __('Send Reset Link') }}
                </x-button-primary>
            </form>

            <div class="mt-8 text-center">
                <p class="text-base-content text-sm">
                    {{ __('Remember your password? ') }} <a class="text-primary hover:text-primary/70 font-medium hover:underline" href={{ route('login') }}> {{ __('Sign in') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
