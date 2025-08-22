@section('title', $data['title'] ?? 'Register' . ' | ' . config('app.name'))
@section('meta_description', '')

<x-guest-layout>
    <div class="mx-auto flex min-h-screen w-full flex-col overflow-hidden bg-white p-2 md:flex-row">
        <!-- Left Side - Image and Quote -->
        <div class="relative hidden h-screen w-full md:block md:w-1/2">
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-bl from-[#84cc16] via-[#16a34a] to-[#0f766e] opacity-80"></div>
            <img class="h-full w-full rounded-3xl object-cover" src="https://placehold.co/600x800/1a1a1a/ffffff?text=Abstract+Design" alt="Background">

            <div class="absolute inset-0 flex flex-col justify-between p-8 text-white">
                <div class="text-sm font-medium uppercase tracking-wider">
                    <span class="inline-block">{{ __('Join Us Today') }}</span>
                    <span class="ml-2 inline-block h-1 w-16 bg-white opacity-50"></span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-2xl font-bold leading-tight md:text-3xl">
                        Create Your Account
                    </h1>
                    <p class="max-w-xs text-sm opacity-90">
                        Join our community and unlock exclusive features and benefits.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex flex-col justify-center p-8 md:w-1/2 md:px-12 md:py-6">
            <div class="mb-6 flex items-center text-xl">
                <a class="flex items-end space-x-2" href="/">
                    <x-application-logo class="h-12 w-12 fill-current text-gray-500" />
                    <span class="text-primary text-2xl font-semibold">{{ config('app.name') }}</span>
                </a>
            </div>

            <div class="mb-4">
                <h2 class="text-base-content mb-2 text-3xl font-bold md:text-4xl">{{ __('Create Account') }}</h2>
                <p class="text-base-content-muted">{{ __('Fill in the information below to create your account') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-2" :status="session('status')" />

            @if (env('GOOGLE_CLIENT_ID') && env('GOOGLE_CLIENT_SECRET') ?? false)
                <button class="bg-background text-foreground my-4 flex w-full items-center justify-center space-x-2 rounded-lg border px-4 py-2 text-sm font-medium transition-colors duration-200 hover:opacity-70" type="button">
                    <svg class="h-auto w-4" width="40" height="42" viewBox="0 0 46 47" fill="none">
                        <path d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z" fill="#4285F4" />
                        <path d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z" fill="#34A853" />
                        <path d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z" fill="#FBBC05" />
                        <path d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z" fill="#EB4335" />
                    </svg>
                    <span>
                        {{ __('Continue with with Google') }}
                    </span>
                </button>

                <div class="my-2 mb-6 flex items-center text-xs uppercase text-gray-400 before:me-6 before:flex-1 before:border-t before:border-gray-200 after:ms-6 after:flex-1 after:border-t after:border-gray-200 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">{{ __('or') }}</div>
            @endif

            <form class="space-y-4 md:space-y-4" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name & Username -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Username -->
                    <div>
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input class="mt-1 block w-full" id="username" name="username" type="text" :value="old('username')" required autocomplete="username" placeholder="johndoe" />
                        <x-input-error class="mt-2" :messages="$errors->get('username')" />
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" required autocomplete="username" placeholder="name@mail.com" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Password & Confirm Password -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative">
                            <x-text-input class="mt-1 block w-full pr-10" id="password" name="password" type="password" required autocomplete="new-password" placeholder="**********" />
                            <!-- Toggle Button -->
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" type="button" onclick="togglePassword('password')">
                                <i class="ri-eye-off-line" id="icon-password"></i>
                            </button>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <div class="relative">
                            <x-text-input class="mt-1 block w-full pr-10" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="**********" />
                            <!-- Toggle Button -->
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" type="button" onclick="togglePassword('password_confirmation')">
                                <i class="ri-eye-off-line" id="icon-password_confirmation"></i>
                            </button>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>


                <!-- Terms -->
                <div class="flex items-center">
                    <input class="text-primary focus:ring-primary/90 h-4 w-4 rounded border-gray-300" id="terms" name="terms" type="checkbox" required>
                    <label class="text-base-content ml-2 block text-sm" for="terms">
                        I agree to the
                        <a class="text-primary hover:text-primary/70 font-medium" href="#">Terms of Service</a>
                        and
                        <a class="text-primary hover:text-primary/70 font-medium" href="#">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit -->
                <x-button-primary class="w-full" type="submit">
                    {{ __('Register') }}
                </x-button-primary>
            </form>

            <div class="mt-8 text-center">
                <p class="text-base-content text-sm">
                    {{ __('Already have an account?') }} <a class="text-primary hover:text-primary/70 font-medium hover:underline" href={{ route('login') }}> {{ __('Log in') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
