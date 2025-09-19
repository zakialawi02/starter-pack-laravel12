<div class="bg-background border-foreground/10 sticky top-0 z-10 border-b p-3" id="sidebar-header">
    <div class="mb-2 flex items-center justify-between lg:hidden">
        <!-- Logo -->
        <a class="focus:outline-hidden inline-flex flex-none items-end rounded-xl py-1 text-xl font-semibold focus:opacity-80" href="/dashboard" aria-label="Preline">
            <x-application-logo class="h-auto max-h-10 max-w-28 dark:invert" />
            <h1 class="text-base font-semibold uppercase">Dashboard</h1>
        </a>
        <!-- End Logo -->

        <!-- Sidebar Toggle -->
        <button class="size-7.5 focus:outline-hidden text-foreground/70 inline-flex items-center gap-x-1 rounded-md p-1.5 text-xs disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#hs-pro-sidebar" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-pro-sidebar">
            <i class="ri-close-fill"></i>
            <span class="sr-only">Sidebar Toggle Close</span>
        </button>
    </div>

    <button class="shadow-xs focus:outline-hidden hover:border-foreground/30 focus:border-foreground/30 border-foreground/25 text-foreground/80 bg-neutral inline-flex w-full items-center gap-x-2 rounded-lg border p-1.5 ps-2.5 text-sm disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#hs-pro-cmsssm" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-pro-cmsssm">
        Search
        <span class="border-foreground/25 ms-auto flex items-center gap-x-1 rounded-md border px-1.5 py-px">
            <svg class="size-2.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 6v12a3 3 0 1 0 3-3H6a3 3 0 1 0 3 3V6a3 3 0 1 0-3 3h12a3 3 0 1 0-3-3"></path>
            </svg>
            <span class="text-[11px] uppercase">k</span>
        </span>
    </button>
</div>
