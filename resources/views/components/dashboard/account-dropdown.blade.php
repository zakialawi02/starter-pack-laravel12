<div {{ $attributes->merge(['class' => 'hs-dropdown relative inline-flex [--placement:bottom-right]']) }}>
    <button class="focus:outline-hidden text-foreground/80 inline-flex size-8 items-center justify-center gap-x-2 rounded-full border border-transparent text-sm font-semibold disabled:pointer-events-none disabled:opacity-50" id="hs-dropdown-account" type="button" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
        <img class="size-8 shrink-0 rounded-full" src="{{ Auth::user()->profile_photo_path }}" alt="Avatar">
    </button>

    <div class="hs-dropdown-menu duration hs-dropdown-open:opacity-100 bg-neutral mt-2 hidden min-w-60 rounded-lg opacity-0 shadow-md transition-[opacity,margin] before:absolute before:-top-4 before:start-0 before:h-4 before:w-full after:absolute after:-bottom-4 after:start-0 after:h-4 after:w-full" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account">
        <div class="bg-foreground/15 rounded-t-lg px-5 py-3">
            <p class="text-foreground/55 text-sm">{{ __('Signed in as') }}</p>
            <p class="text-foreground/80 text-sm font-medium">{{ Auth::user()->email }}</p>
        </div>
        <div class="space-y-0.5 p-1.5">
            <x-dashboard.dropdown-link href="{{ route('admin.profile.edit') }}" icon="ri-user-line">
                {{ __('Profile') }}
            </x-dashboard.dropdown-link>
            <x-dashboard.dropdown-link href="#" icon="ri-settings-line">
                {{ __('Settings') }}
            </x-dashboard.dropdown-link>
            <x-dashboard.logout-form />
        </div>
    </div>
</div>
