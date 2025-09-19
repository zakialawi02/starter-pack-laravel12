<li class="after:bg-foreground/30 text-foreground/70 relative inline-flex items-center gap-1.5 pe-3 after:absolute after:end-0 after:top-1/2 after:inline-block after:h-3.5 after:w-px after:-translate-y-1/2 after:rotate-12 after:rounded-full last:pe-0 last:after:hidden">
    <div class="h-8">
        <!-- Account Dropdown -->
        <div class="hs-dropdown relative inline-flex text-start [--auto-close:inside] [--placement:bottom-right] [--strategy:absolute]">
            <button class="focus:outline-hidden hover:bg-foreground/25 focus:bg-foreground/25 inline-flex shrink-0 items-center gap-x-3 rounded-full p-0.5 text-start" id="hs-dnad" type="button" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                <img class="size-7 shrink-0 rounded-full" src="{{ Auth::user()->profile_photo_path }}" alt="Avatar">
            </button>

            <!-- Account Dropdown -->
            <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 duration border-foreground/25 bg-neutral z-20 hidden w-60 rounded-xl border opacity-0 shadow-xl transition-[opacity,margin]" role="menu" aria-orientation="vertical" aria-labelledby="hs-dnad">
                <div class="px-3.5 py-2">
                    <span class="text-foreground font-medium">
                        {{ Auth::user()->name }}
                    </span>
                    <p class="text-foreground/70 text-sm">
                        {{ Auth::user()->email }}
                    </p>
                </div>
                <div class="border-foreground/25 border-t px-4 py-2">
                    <x-dashboard.theme-toggle />
                </div>
                <div class="border-foreground/25 border-t p-1">
                    <x-dashboard.dropdown-link href="#" icon="ri-user-line">
                        Profile
                    </x-dashboard.dropdown-link>
                    <x-dashboard.dropdown-link href="#" icon="ri-settings-line">
                        Settings
                    </x-dashboard.dropdown-link>
                    <x-dashboard.logout-form />
                </div>
            </div>
            <!-- End Account Dropdown -->
        </div>
        <!-- End Account Dropdown -->
    </div>
</li>
