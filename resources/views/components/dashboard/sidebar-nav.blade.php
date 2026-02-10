@php
    use Illuminate\Support\Facades\Auth;

    $currentUser = Auth::user();
    $isSuperAdmin = $currentUser && $currentUser->hasRole('superadmin');
@endphp

<nav class="hs-accordion-group flex w-full flex-col flex-wrap p-3" data-hs-accordion-always-open>
    <ul class="flex flex-col space-y-1">
        <x-dashboard.nav-item href="/" icon="ri-home-4-line" text="{{ __('Home') }}" />
        <x-dashboard.nav-item href="admin.dashboard" icon="ri-dashboard-line" text="{{ __('Dashboard') }}" />

        <x-dashboard.nav-accordion id="template-accordion" icon="ri-pages-line" text="{{ __('Templates') }}">
            <x-dashboard.nav-item href="/dashboard" text="{{ __('Dashboard') }}" />
            <x-dashboard.nav-item href="{{ route('admin.dashboard.empty') }}" text="{{ __('Dashboard Template') }}" />
            <x-dashboard.nav-item href="#" text="{{ __('Link 3') }}" />
        </x-dashboard.nav-accordion>

        <x-dashboard.nav-accordion id="projects-accordion" icon="ri-briefcase-4-line" text="{{ __('Projects') }}">
            <x-dashboard.nav-item href="#" text="{{ __('Link 1') }}" />
            <x-dashboard.nav-item href="#" text="{{ __('Link 2') }}" />
            <x-dashboard.nav-item href="#" text="{{ __('Link 3') }}" />
        </x-dashboard.nav-accordion>

        <div class="text-base-content-muted border-foreground/20 border-b px-1 pt-3 text-sm font-bold">
            <p>{{ __('Manage') }}</p>
        </div>
        @if ($isSuperAdmin)
            <x-dashboard.nav-item href="admin.users.index" icon="ri-user-line" text="{{ __('Users') }}" />
            <x-dashboard.nav-item href="admin.roles.index" icon="ri-shield-user-line" text="{{ __('Roles') }}" />
            <x-dashboard.nav-item href="admin.permissions.index" icon="ri-lock-line" text="{{ __('Permissions') }}" />
            <x-dashboard.nav-item href="docs" icon="ri-file-list-3-line" text="{{ __('Route Docs') }}" target="_blank" />
        @endif

        @if ($isSuperAdmin)
            <div class="text-base-content-muted border-foreground/30 border-b px-1 pt-3 text-sm font-bold">
                <p>{{ __('Settings') }}</p>
            </div>
        @endif
    </ul>
</nav>

