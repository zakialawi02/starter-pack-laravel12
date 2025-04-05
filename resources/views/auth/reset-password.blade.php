<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input name="token" type="hidden" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="name@mail.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input class="mt-1 block w-full" id="password" name="password" type="password" required autocomplete="new-password" placeholder="**********" />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input class="mt-1 block w-full" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="**********" />

            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <x-dashboard.primary-button class="w-full">
                {{ __('Reset Password') }}
            </x-dashboard.primary-button>
        </div>
    </form>
</x-guest-layout>
