<a href="{{ $href ?? '#' }}" {{ $attributes->merge(['class' => 'focus:outline-hidden text-foreground/80 hover:bg-foreground/20 focus:bg-foreground/20 flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm disabled:pointer-events-none disabled:opacity-50']) }}>
    @if (isset($icon))
        <i class="{{ $icon }}"></i>
    @endif
    <span>{{ $slot }}</span>
</a>
