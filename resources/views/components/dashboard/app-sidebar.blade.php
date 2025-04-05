<aside class="w-65 dark:bg-dark-base-100 z-38 fixed inset-y-0 start-0 h-full -translate-x-full transform border-e border-gray-200 bg-white transition-all duration-300 lg:bottom-0 lg:end-auto lg:block lg:translate-x-0 dark:border-slate-700" id="sidebar-multi-level-sidebar" role="dialog" aria-label="Sidebar" tabindex="-1">
    <div class="relative flex h-full max-h-full flex-col">
        <div class="align-center flex items-center px-5 py-1.5">
            <!-- Logo -->
            <a class="focus:outline-hidden inline-block flex-none rounded-xl text-xl font-semibold focus:opacity-80" href="#" aria-label="Preline">
                <img class="h-auto max-w-24" src="{{ asset('assets/img/logo.png') }}" alt="Logo Application">
            </a>
            <!-- End Logo -->

            <div class="ms-2 lg:hidden">
                <button class="absolute end-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-drawer-hide="sidebar-multi-level-sidebar"aria-controls="sidebar-multi-level-sidebar" type="button">
                    <i class="ri-close-large-line font-semibold"></i>
                    <span class="sr-only">Close menu</span>
                </button>
            </div>
        </div>

        <hr class="h-px border-0 bg-gray-200 dark:bg-slate-700">

        <!-- Content -->
        <div class="h-full overflow-y-auto [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 [&::-webkit-scrollbar-track]:bg-gray-100 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 [&::-webkit-scrollbar]:w-2">
            <nav class="flex w-full flex-col flex-wrap p-3">
                <ul class="flex flex-col space-y-1">
                    <x-dashboard.nav-item route="admin.dashboard" icon="ri-dashboard-line" text="Dashboard" />
                    <x-dashboard.nav-item route="/" icon="ri-home-4-line" text="Home" />
                    <x-dashboard.nav-item icon="ri-kanban-view-2" text="Kanban" badge="Pro" />
                    <x-dashboard.nav-item icon="ri-inbox-fill" text="Inbox" badge="3" />

                    <x-dashboard.nav-dropdown icon="ri-store-2-line" text="E-commerce" :items="[['route' => 'admin.dashboard', 'text' => 'Products'], ['route' => 'billing.index', 'text' => 'Billing'], ['route' => 'invoice.index', 'text' => 'Invoice']]" />

                    <div class="px-1 pt-3 text-sm font-bold text-gray-600 dark:text-gray-200">
                        <h5>Management</h5>
                    </div>
                    <x-dashboard.nav-item route="admin.users.index" icon="ri-user-line" text="User" />
                    <x-dashboard.nav-item route="docs" icon="ri-file-list-3-line" text="Route Docs" target="_blank" />
                    <x-dashboard.nav-item route="admin.setting" icon="ri-settings-3-line" text="Setting" />

                </ul>
            </nav>
        </div>
        <!-- End Content -->
    </div>
</aside>
