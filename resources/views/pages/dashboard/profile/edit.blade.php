@section('title', $data['title'] ?? 'My Profile')
@section('meta_description', '')

<x-app-layout>
    <div class="p-4 md:flex">
        <ul class="flex-column space-y mb-4 space-y-4 text-sm font-medium md:mb-0 md:me-4" id="default-tab" data-tabs-toggle="#default-tab-content" data-tabs-active-classes="text-primary" role="tablist">
            <li>
                <button class="bg-neutral hover:bg-muted hover:text-foreground inline-flex w-full items-center rounded-lg px-4 py-3" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="{{ $errors->get('name') || $errors->get('email') || session('status') === 'profile-updated' ? 'true' : 'false' }}">
                    <i class="ri-account-circle-fill me-1 text-xl"></i>
                    Profile
                </button>
            </li>
            <li>
                <button class="bg-neutral hover:bg-muted hover:text-foreground inline-flex w-full items-center rounded-lg px-4 py-3" id="account-tab" data-tabs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="{{ $errors->userDeletion->isNotEmpty() || $errors->updatePassword->isNotEmpty() ? 'true' : 'false' }}">
                    <i class="ri-settings-5-line me-1 text-xl"></i>
                    Account
                </button>
            </li>
        </ul>

        <div class="w-full" id="default-tab-content">
            <div class="text-medium bg-neutral border-border hidden w-full rounded-lg border p-6 shadow-md" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="mb-8 max-w-xl">
                    @include('pages.dashboard.profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="text-medium bg-neutral border-border hidden w-full rounded-lg border p-6 shadow-md" id="account" role="tabpanel" aria-labelledby="account-tab">
                <div class="mb-8 max-w-xl">
                    @include('pages.dashboard.profile.partials.update-password-form')
                </div>

                <div class="mb-8 max-w-xl">
                    @include('pages.dashboard.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
