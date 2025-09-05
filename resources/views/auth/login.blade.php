@section('title', $data['title'] ?? 'Login' . ' | ' . config('app.name'))
@section('meta_description', '')

<x-guest-layout>
    <div class="bg-background mx-auto flex h-screen w-full flex-col overflow-hidden p-2 md:flex-row">
        <!-- Left Side - Image and Quote -->
        <div class="relative hidden md:block md:w-1/2">
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-bl from-[#84cc16] via-[#16a34a] to-[#0f766e] opacity-80"></div>
            <img class="h-full w-full rounded-3xl object-cover" src="https://placehold.co/600x800/1a1a1a/ffffff?text=Abstract+Design" alt="Background">

            <div class="absolute inset-0 flex flex-col justify-between p-8 text-white">
                <div class="text-sm font-medium uppercase tracking-wider">
                    <span class="inline-block">{{ __('Login') }}</span>
                    <span class="ml-2 inline-block h-1 w-16 bg-white opacity-50"></span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-2xl font-bold leading-tight md:text-3xl">
                        {{ config('app.name') }}
                    </h1>
                    {{-- <p class="max-w-xs text-sm opacity-90">
                        You can get everything you want if you work hard, trust the process, and stick to the plan.
                    </p> --}}
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex flex-col overflow-y-auto p-8 md:w-1/2 md:px-12 md:py-6">
            <div class="mb-10 flex items-center text-xl">
                <a class="flex items-end space-x-2" href="/">
                    <x-application-logo class="h-12 w-12 fill-current text-gray-500" />
                    <span class="text-primary text-2xl font-semibold">{{ config('app.name') }}</span>
                </a>
            </div>

            <div class="mb-8">
                <h2 class="text-base-content mb-2 text-3xl font-bold md:text-4xl">{{ __('Welcome Back') }}</h2>
                <p class="text-base-content-muted">{{ __('Enter your email and password to access your account') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if ((env('GOOGLE_CLIENT_ID') && env('GOOGLE_CLIENT_SECRET')) || (env('GITHUB_CLIENT_ID') && env('GITHUB_CLIENT_SECRET')) || (env('FACEBOOK_CLIENT_ID') && env('FACEBOOK_CLIENT_SECRET')))
                <div class="space-y-3">
                    @if (env('GOOGLE_CLIENT_ID') && env('GOOGLE_CLIENT_SECRET'))
                        <a class="bg-background text-foreground flex w-full items-center justify-center space-x-2 rounded-lg border px-4 py-2 text-sm font-medium transition-colors duration-200 hover:opacity-70" type="button" href="{{ route('auth.redirect', ['provider' => 'google'] + (request()->has('redirect') ? ['redirect' => request()->get('redirect')] : [])) }}">
                            <svg class="h-auto w-4" width="40" height="42" viewBox="0 0 46 47" fill="none">
                                <path d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z" fill="#4285F4" />
                                <path d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z" fill="#34A853" />
                                <path d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z" fill="#FBBC05" />
                                <path d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z" fill="#EB4335" />
                            </svg>
                            <span>
                                {{ __('Continue with Google') }}
                            </span>
                        </a>
                    @endif

                    @if (env('FACEBOOK_CLIENT_ID') && env('FACEBOOK_CLIENT_SECRET'))
                        <a class="bg-background text-foreground flex w-full items-center justify-center space-x-2 rounded-lg border px-4 py-2 text-sm font-medium transition-colors duration-200 hover:opacity-70" type="button" href="{{ route('auth.redirect', ['provider' => 'facebook'] + (request()->has('redirect') ? ['redirect' => request()->get('redirect')] : [])) }}">
                            <svg class="w-4.5 h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="-204.79995 -341.33325 1774.9329 2047.9995">
                                <path d="M1365.333 682.667C1365.333 305.64 1059.693 0 682.667 0 305.64 0 0 305.64 0 682.667c0 340.738 249.641 623.16 576 674.373V880H402.667V682.667H576v-150.4c0-171.094 101.917-265.6 257.853-265.6 74.69 0 152.814 13.333 152.814 13.333v168h-86.083c-84.804 0-111.25 52.623-111.25 106.61v128.057h189.333L948.4 880H789.333v477.04c326.359-51.213 576-333.635 576-674.373" fill="#1877f2" />
                                <path d="M948.4 880l30.267-197.333H789.333V554.609C789.333 500.623 815.78 448 900.584 448h86.083V280s-78.124-13.333-152.814-13.333c-155.936 0-257.853 94.506-257.853 265.6v150.4H402.667V880H576v477.04a687.805 687.805 0 00106.667 8.293c36.288 0 71.91-2.84 106.666-8.293V880H948.4" fill="#fff" />
                            </svg>
                            <span>
                                {{ __('Continue with Facebook') }}
                            </span>
                        </a>
                    @endif

                    @if (env('GITHUB_CLIENT_ID') && env('GITHUB_CLIENT_SECRET'))
                        <a class="bg-background text-foreground flex w-full items-center justify-center space-x-2 rounded-lg border px-4 py-2 text-sm font-medium transition-colors duration-200 hover:opacity-70" type="button" href="{{ route('auth.redirect', ['provider' => 'github'] + (request()->has('redirect') ? ['redirect' => request()->get('redirect')] : [])) }}">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                            </svg>
                            <span>
                                {{ __('Continue with GitHub') }}
                            </span>
                        </a>
                    @endif
                </div>

                <div class="my-4 mb-3 flex items-center text-xs uppercase text-gray-400 before:me-6 before:flex-1 before:border-t before:border-gray-200 after:ms-6 after:flex-1 after:border-t after:border-gray-200 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">{{ __('or') }}</div>
            @endif

            <form class="space-y-3 md:space-y-4" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="id_user" :value="__('Username/Email')" />
                    <x-text-input class="mt-1 block w-full" id="id_user" name="id_user" type="text" :value="old('id_user')" required autofocus autocomplete="username" placeholder="name@mail.com" />
                    <x-input-error class="mt-2" :messages="$errors->get('id_user')" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full pr-10" id="password" name="password" type="password" required autocomplete="current-password" placeholder="**********" />
                        <!-- Toggle Button -->
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" type="button" onclick="togglePassword('password')">
                            <i class="ri-eye-off-line" id="icon-password"></i>
                        </button>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <!-- Remember Me -->
                        <div class="mt-2">
                            <label class="inline-flex items-center" for="remember_me">
                                <input class="shadow-xs text-primary focus:ring-primary rounded-sm" id="remember_me" name="remember" type="checkbox">
                                <span class="text-base-content ms-2 text-sm">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-base-content hover:text-base-content/70 text-sm font-medium hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <x-button-primary class="w-full" type="submit">
                    {{ __('Log in') }}
                </x-button-primary>

            </form>

            <div class="mt-8 text-center">
                <p class="text-base-content text-sm">
                    {{ __('Don’t have an account yet?') }} <a class="text-primary hover:text-primary/70 font-medium hover:underline" href={{ route('register') }}> {{ __('Sign up') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
