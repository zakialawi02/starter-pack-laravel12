 <div class="hs-overlay hs-overlay-open:translate-x-0 w-65 z-49 border-foreground/10 bg-neutral fixed inset-y-0 start-0 hidden h-full -translate-x-full transform border-e transition-all duration-300 [--auto-close:lg] lg:bottom-0 lg:end-auto lg:block lg:translate-x-0" id="hs-application-sidebar" role="dialog" aria-label="Sidebar" tabindex="-1">
     <div class="relative flex h-full max-h-full flex-col">
         <div class="flex items-center px-6 pb-2 pt-2 align-baseline">
             <!-- Logo -->
             <a class="focus:outline-hidden inline-flex flex-none items-end rounded-xl py-1 text-xl font-semibold focus:opacity-80" href="/dashboard" aria-label="Preline">
                 <x-application-logo class="h-auto max-h-10 max-w-28 dark:invert" />
                 <h1 class="text-foreground text-base font-semibold uppercase">Dashboard</h1>
             </a>

             <div class="ms-2 lg:hidden">
                 <button class="text-foreground/60 hover:bg-muted hover:text-foreground/90 absolute end-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm" data-hs-overlay="#hs-application-sidebar" type="button" aria-controls="hs-application-sidebar">
                     <i class="ri-close-large-line font-semibold"></i>
                     <span class="sr-only">Close menu</span>
                 </button>
             </div>
         </div>

         <!-- Content -->
         <div class="[&::-webkit-scrollbar-thumb]:bg-foreground/30 [&::-webkit-scrollbar-track]:bg-foreground/15 h-full flex-grow overflow-y-auto [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar]:w-2">
             <!-- Nav Sidebar -->
             <x-dashboard.sidebar-nav />
         </div>
         <!-- End Content -->

         <!-- Footer Sidebar - positioned at the bottom -->
         <div class="mt-auto flex-shrink-0">
             <x-dashboard.sidebar-footer />
         </div>
     </div>
 </div>
