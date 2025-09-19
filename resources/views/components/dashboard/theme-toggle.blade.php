<!-- Switch/Toggle -->
<div class="flex flex-wrap items-center justify-between gap-2">
    <span class="text-foreground/80 flex-1 cursor-pointer text-sm">Theme</span>
    <div class="bg-foreground/20 inline-flex cursor-pointer rounded-full p-0.5">
        <button class="hs-auto-mode-active:bg-transparent hs-auto-mode-active:shadow-none hs-dark-mode-active:bg-transparent hs-dark-mode-active:shadow-none text-foreground bg-neutral flex size-7 items-center justify-center rounded-full shadow-sm" data-hs-theme-click-value="default" type="button">
            <i class="ri-sun-line"></i>
            <span class="sr-only">Default (Light)</span>
        </button>
        <button class="hs-dark-mode-active:bg-neutral hs-dark-mode-active:shadow-sm hs-dark-mode-active:text-foreground text-foreground flex size-7 items-center justify-center rounded-full" data-hs-theme-click-value="dark" type="button">
            <i class="ri-moon-line"></i>
            <span class="sr-only">Dark</span>
        </button>
        <button class="hs-auto-light-mode-active:bg-neutral hs-auto-dark-mode-active:bg-primary hs-auto-mode-active:shadow-sm text-foreground flex size-7 items-center justify-center rounded-full" data-hs-theme-click-value="auto" type="button">
            <i class="ri-computer-line"></i>
            <span class="sr-only">Auto (System)</span>
        </button>
    </div>
</div>
