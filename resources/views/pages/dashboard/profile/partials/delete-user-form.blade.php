<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-muted dark:text-light/70 mt-1 text-sm">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-dashboard.danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-dashboard.danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form class="p-6" method="post" action="{{ route('admin.profile.destroy') }}">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-muted dark:text-light/70 mt-1 text-sm">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label class="sr-only" for="password" value="{{ __('Password') }}" />

                <x-text-input class="mt-1 block w-3/4" id="password" name="password" type="password" placeholder="{{ __('Password') }}" />

                <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-dashboard.secondary-button type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-dashboard.secondary-button>

                <x-dashboard.danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-dashboard.danger-button>
            </div>
        </form>
    </x-modal>
</section>
