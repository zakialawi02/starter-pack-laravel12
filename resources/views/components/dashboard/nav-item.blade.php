@props([
    'href' => '#',
    'icon' => '',
    'text' => '...',
    'badge' => false,
    'active' => '',
    'class' => '',
    'target' => null,
    'disabled' => false,
])

@php
    // Determine whether the route is a named route or a regular URL
    $isNamedRoute = $href && Route::has($href);
    $isActive = $isNamedRoute && Request::routeIs($href) ? 'active' : '';

    // Use named routes if available, otherwise use direct URLs.
    $href = $isNamedRoute ? route($href) : ($href ? url($href) : '#');

    // For href, we can't easily determine active state, so we'll use a simple URL comparison
    $currentUrl = url()->current();
    $isActive = $href !== '#' && $currentUrl === rtrim(url($href), '/') ? 'active' : '';

    // Handle disabled state
    $disabledClass = $disabled ? 'opacity-50 pointer-events-none' : '';

    // Merge classes
    $mergedClass = "group flex items-center rounded-lg px-2 py-1.5 text-foreground hover:bg-foreground/20 $class $disabledClass " . ($isActive ? 'bg-foreground/20 ' : '');
@endphp

<li class="{{ $isActive }} {{ $active }} group">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $mergedClass]) }} @if ($target) target="{{ $target }}" @endif @if ($disabled) aria-disabled="true" @endif>
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span class="ms-3 flex-1 whitespace-nowrap">{{ $text }}</span>
        @if ($badge)
            <span class="bg-primary text-primary-foreground ms-3 inline-flex items-center justify-center rounded-full px-2 text-sm font-medium">{{ $badge }}</span>
        @endif
    </a>
</li>
