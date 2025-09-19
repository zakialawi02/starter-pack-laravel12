<header class="z-48 lg:z-61 bg-background fixed inset-x-0 top-0 flex w-full flex-wrap py-2.5 text-sm md:flex-nowrap md:justify-start">
    <nav class="sm:px-5.5 mx-auto flex w-full basis-full items-center px-4">
        <div class="flex w-full items-center gap-x-1.5">
            <ul class="flex items-center gap-1.5">
                <li class="after:bg-foreground/30 text-foreground/25 relative inline-flex items-center pe-1.5 after:absolute after:end-0 after:top-1/2 after:inline-block after:h-3.5 after:w-px after:-translate-y-1/2 after:rotate-12 after:rounded-full last:pe-0 last:after:hidden">
                    <a class="focus:outline-hidden inline-flex flex-none items-end rounded-xl py-1 text-xl font-semibold focus:opacity-80" href="/dashboard" aria-label="Preline">
                        <x-application-logo class="h-auto max-h-8 max-w-28 dark:invert" />
                        <div class="ms-1 hidden sm:block">
                            <!-- Title -->
                        </div>
                    </a>

                    <!-- Sidebar Toggle -->
                    <button class="size-7.5 focus:outline-hidden text-foreground/70 hover:text-foreground focus:text-foreground inline-flex items-center gap-x-1 rounded-md border border-transparent p-1.5 text-xs disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#hs-pro-sidebar" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-pro-sidebar">
                        <i class="ri-sidebar-unfold-line text-xl"></i>
                        <span class="sr-only">Sidebar Toggle</span>
                    </button>
                </li>


                <!-- Breadcrumb -->
                <x-dashboard.breadcrumb :items="generate_breadcrumbs()" />
            </ul>

            <ul class="ms-auto flex flex-row items-center gap-x-3">
                <x-dashboard.account-dropdown />
            </ul>
        </div>
    </nav>
</header>
