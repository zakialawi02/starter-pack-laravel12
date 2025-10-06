<section>
    <header>
        <h2 class="text-base-content text-lg font-medium">
            {{ __('Update Password') }}
        </h2>

        <p class="text-base-content-muted mt-1 text-sm">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>


    @if (Auth::user()->password && !Auth::user()->provider_name)
        <form class="mt-6 space-y-6" method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input class="mt-1 block w-full" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input class="mt-1 block w-full" id="update_password_password" name="password" type="password" autocomplete="new-password" />
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input class="mt-1 block w-full" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>

            <div class="flex items-center gap-4">
                <x-button-primary type="submit">{{ __('Save') }}</x-button-primary>

                @if (session('status') === 'password-updated')
                    <p class="text-sm text-gray-600" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    @else
        <div class="mt-6">
            <p class="text-sm text-gray-600">
                {{ __('You are logged in via social login. Please update your password in your social account settings.') }}
                {{ __('You are currently logged in using :provider.', ['provider' => ucfirst(Auth::user()->provider_name)]) }}
            </p>
        </div>
    @endif
</section>
