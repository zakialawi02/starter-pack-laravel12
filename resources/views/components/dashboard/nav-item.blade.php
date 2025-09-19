@props([
    'route' => false,
    'href' => false,
    'icon' => '',
    'text' => '...',
    'badge' => false,
    'active' => '',
    'class' => '',
    'target' => null,
    'disabled' => false,
])

@php
    // Determine the correct URL to use
    if ($route) {
        // Check if it's a named route
    $isNamedRoute = Route::has($route);
    $isActive = $isNamedRoute && Request::routeIs($route) ? 'active' : '';
    $url = $isNamedRoute ? route($route) : url($route);
} elseif ($href) {
    $url = $href;
    // For href, we can't easily determine active state, so we'll use a simple URL comparison
    $currentUrl = url()->current();
    $isActive = $href !== '#' && $currentUrl === rtrim(url($href), '/') ? 'active' : '';
} else {
    $url = '#';
    $isActive = '';
}

// Handle disabled state
$disabledClass = $disabled ? 'opacity-50 pointer-events-none' : '';

// Merge classes
$mergedClass = "group flex items-center rounded-lg px-2 py-1.5 text-foreground hover:bg-foreground/20 $class $disabledClass " . ($isActive ? 'bg-foreground/20 ' : '');
@endphp

<li class="{{ $isActive }} {{ $active }} group">
    <a href="{{ $url }}" {{ $attributes->merge(['class' => $mergedClass]) }} @if ($target) target="{{ $target }}" @endif @if ($disabled) aria-disabled="true" @endif>
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span class="ms-3 flex-1 whitespace-nowrap">{{ $text }}</span>
        @if ($badge)
            <span class="bg-primary text-primary-foreground ms-3 inline-flex items-center justify-center rounded-full px-2 text-sm font-medium">{{ $badge }}</span>
        @endif
    </a>
</li>
