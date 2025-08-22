@section('title', $data['title'] ?? 'Account Verification' . ' | ' . config('app.name'))
@section('meta_description', '')

<x-guest-layout>
    <div class="mx-auto flex h-screen w-full flex-col overflow-hidden bg-white p-2 md:flex-row">
        <!-- Left Side - Image and Quote -->
        <div class="relative hidden md:block md:w-1/2">
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-bl from-[#84cc16] via-[#16a34a] to-[#0f766e] opacity-80"></div>
            <img class="h-full w-full rounded-3xl object-cover" src="https://placehold.co/600x800/1a1a1a/ffffff?text=Abstract+Design" alt="Background">

            <div class="absolute inset-0 flex flex-col justify-between p-8 text-white">
                <div class="text-sm font-medium uppercase tracking-wider">
                    <span class="inline-block">{{ __('Account Verification') }}</span>
                    <span class="ml-2 inline-block h-1 w-16 bg-white opacity-50"></span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-2xl font-bold leading-tight md:text-3xl">
                        {{ __('Verify Your Account') }}
                    </h1>
                    <p class="max-w-xs text-sm opacity-90">
                        {{ __('Complete your registration by verifying your email address.') }}
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

            <div class="mb-8 text-center">
                <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-green-100">
                    <svg class="text-success h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    </svg>
                </div>

                <h2 class="text-base-content mb-4 text-3xl font-bold md:text-4xl">Check Your Email</h2>
                <p class="text-base-content-muted mb-2">We've sent a verification link to:</p>
                <p class="text-base-content mb-6 text-lg font-semibold">{{ Auth::user()->email }}</p>
                <p class="text-base-content-muted">Please check your inbox and click the verification link to activate your account.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="text-success mb-4 text-center text-sm font-medium">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <x-button-primary class="w-full" type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-button-primary>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button-danger class="w-full" type="submit">
                        {{ __('Log Out') }}
                    </x-button-danger>
                </form>
            </div>

            <div class="mt-8 text-center">
                <p class="text-base-content text-sm">
                    Didn't receive the email? Check your spam folder or
                    <a class="text-primary hover:text-primary/70 font-medium hover:underline" href="#">contact support</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
