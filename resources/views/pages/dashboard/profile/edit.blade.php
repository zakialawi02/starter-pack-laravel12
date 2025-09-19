@section('title', $data['title'] ?? 'My Profile')
@section('meta_description', '')

<x-app-layout>
    <!-- Tab Navigation -->
    <div class="flex p-2">
        <div class="flex rounded-lg bg-gray-100 p-1 transition hover:bg-gray-200">
            <nav class="flex gap-x-1" role="tablist" aria-label="Tabs" aria-orientation="horizontal">
                <button class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: focus:outline-hidden {{ $errors->get('name') || $errors->get('email') || session('status') === 'profile-updated' || !($errors->userDeletion->isNotEmpty() || $errors->updatePassword->isNotEmpty()) ? 'active' : '' }} inline-flex items-center gap-x-2 rounded-lg bg-transparent px-4 py-3 text-sm font-medium text-gray-500 hover:hover:text-blue-600 hover:text-gray-700 focus:text-gray-700 disabled:pointer-events-none disabled:opacity-50" id="profile-tab" data-hs-tab="#profile" type="button" role="tab" aria-selected="{{ $errors->get('name') || $errors->get('email') || session('status') === 'profile-updated' || !($errors->userDeletion->isNotEmpty() || $errors->updatePassword->isNotEmpty()) ? 'true' : 'false' }}" aria-controls="profile">
                    <i class="ri-account-circle-fill text-xl"></i>
                    {{ __('Profile') }}
                </button>
                <button class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: focus:outline-hidden {{ ($errors->userDeletion->isNotEmpty() || $errors->updatePassword->isNotEmpty()) && !($errors->get('name') || $errors->get('email') || session('status') === 'profile-updated') ? 'active' : '' }} inline-flex items-center gap-x-2 rounded-lg bg-transparent px-4 py-3 text-sm font-medium text-gray-500 hover:hover:text-blue-600 hover:text-gray-700 focus:text-gray-700 disabled:pointer-events-none disabled:opacity-50" id="account-tab" data-hs-tab="#account" type="button" role="tab" aria-selected="{{ $errors->userDeletion->isNotEmpty() || $errors->updatePassword->isNotEmpty() ? 'true' : 'false' }}" aria-controls="account">
                    <i class="ri-settings-5-line text-xl"></i>
                    {{ __('Account') }}
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="p-2">
        <!-- Profile Tab -->
        <x-card id="profile" role="tabpanel" aria-labelledby="profile-tab" @class([
            'hidden' => !(
                $errors->get('name') ||
                $errors->get('email') ||
                session('status') === 'profile-updated' ||
                !(
                    $errors->userDeletion->isNotEmpty() ||
                    $errors->updatePassword->isNotEmpty()
                )
            ),
        ])>
            <div class="max-w-xl">
                @include('pages.dashboard.profile.partials.update-profile-information-form')
            </div>
        </x-card>

        <!-- Account Tab -->
        <x-card id="account" role="tabpanel" aria-labelledby="account-tab" :class="($errors->userDeletion->isNotEmpty() || $errors->updatePassword->isNotEmpty()) && !($errors->get('name') || $errors->get('email') || session('status') === 'profile-updated') ? '' : 'hidden'">
            <div class="max-w-xl">
                @include('pages.dashboard.profile.partials.update-password-form')
            </div>

            <div class="mt-8 max-w-xl">
                @include('pages.dashboard.profile.partials.delete-user-form')
            </div>
        </x-card>
    </div>
</x-app-layout>
