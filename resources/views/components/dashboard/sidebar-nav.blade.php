<nav class="hs-accordion-group flex w-full flex-col flex-wrap p-3" data-hs-accordion-always-open>
    <ul class="flex flex-col space-y-1">
        <x-dashboard.nav-item route="/" icon="ri-home-4-line" text="Home" />
        <x-dashboard.nav-item route="admin.dashboard" icon="ri-dashboard-line" text="Dashboard" />

        <x-dashboard.nav-accordion id="template-accordion" icon="ri-pages-line" text="Templates">
            <x-dashboard.nav-item href="/dashboard" text="dashboard" />
            <x-dashboard.nav-item href="{{ route('admin.dashboard.empty') }}" text="Dashboard Template" />
            <x-dashboard.nav-item href="#" text="Link 3" />
        </x-dashboard.nav-accordion>

        <x-dashboard.nav-accordion id="projects-accordion" icon="ri-briefcase-4-line" text="Projects">
            <x-dashboard.nav-item href="#" text="Link 1" />
            <x-dashboard.nav-item href="#" text="Link 2" />
            <x-dashboard.nav-item href="#" text="Link 3" />
        </x-dashboard.nav-accordion>

        <div class="text-base-content-muted border-foreground/20 border-b px-1 pt-3 text-sm font-bold">
            <p>Manage</p>
        </div>
        @if (Auth::user()->role == 'superadmin')
            <x-dashboard.nav-item route="admin.users.index" icon="ri-user-line" text="User" />
            <x-dashboard.nav-item route="docs" icon="ri-file-list-3-line" text="Route Docs" target="_blank" />
        @endif

        @if (Auth::user()->role == 'superadmin')
            <div class="text-base-content-muted border-foreground/30 border-b px-1 pt-3 text-sm font-bold">
                <p>Settings</p>
            </div>
        @endif
    </ul>
</nav>
