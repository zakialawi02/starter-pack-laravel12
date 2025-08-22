<aside class="w-65 z-38 bg-neutral border-foreground/30 fixed inset-y-0 start-0 h-full -translate-x-full transform border-e transition-all duration-300 lg:bottom-0 lg:end-auto lg:block lg:translate-x-0" id="sidebar-multi-level-sidebar" role="dialog" aria-label="Sidebar" tabindex="-1">
    <div class="relative flex h-full max-h-full flex-col">
        <div class="align-center flex items-center px-5 py-1.5">
            <!-- Logo -->
            <a class="focus:outline-hidden inline-flex flex-none items-end rounded-xl py-1 text-xl font-semibold focus:opacity-80" href="/dashboard" aria-label="Preline">
                <x-application-logo class="h-auto max-h-10 max-w-28" />
                <h1 class="text-base font-semibold uppercase dark:invert">Dashboard</h1>
            </a>
            <!-- End Logo -->

            <div class="ms-2 lg:hidden">
                <button class="text-foreground/60 hover:bg-muted hover:text-foreground/90 absolute end-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm" data-drawer-hide="sidebar-multi-level-sidebar"aria-controls="sidebar-multi-level-sidebar" type="button">
                    <i class="ri-close-large-line font-semibold"></i>
                    <span class="sr-only">Close menu</span>
                </button>
            </div>
        </div>

        <hr class="bg-foreground/40 h-px border-0">

        <!-- Content -->
        <div class="[&::-webkit-scrollbar-thumb]:bg-primary [&::-webkit-scrollbar-track]:bg-primary-muted h-full overflow-y-auto [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar]:w-1.5">
            <nav class="flex w-full flex-col flex-wrap p-3">
                <ul class="flex flex-col space-y-1">
                    <x-dashboard.nav-item route="/" icon="ri-home-4-line" text="Home" />
                    <x-dashboard.nav-item route="admin.dashboard" icon="ri-dashboard-line" text="Dashboard" />
                    @if (Auth::user()->role !== 'user')
                        <x-dashboard.nav-dropdown icon="ri-article-line" text="Articles Posts" :items="[['route' => 'admin.posts.index', 'text' => 'Posts'], ['route' => 'admin.posts.create', 'text' => 'Create Post']]" />
                    @endif

                    <div class="text-base-content-muted px-1 pt-3 text-sm font-bold">
                        <p>Manage</p>
                    </div>
                    <x-dashboard.nav-item route="#" icon="ri-notification-3-line" text="Notification" />
                    @if (Auth::user()->role == 'superadmin')
                        <x-dashboard.nav-item route="admin.users.index" icon="ri-user-line" text="User" />
                        <x-dashboard.nav-item route="docs" icon="ri-file-list-3-line" text="Route Docs" target="_blank" />
                    @endif

                    @if (Auth::user()->role == 'superadmin')
                        <div class="text-base-content-muted px-1 pt-3 text-sm font-bold">
                            <p>Settings</p>
                        </div>
                    @endif
                </ul>
            </nav>
        </div>
        <!-- End Content -->
    </div>
</aside>
