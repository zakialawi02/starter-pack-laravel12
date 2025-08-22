@props(['route' => false, 'icon' => '', 'text' => '...', 'badge' => false, 'active' => '', 'class' => ''])

@php
    // Tentukan apakah route adalah named route atau URL biasa
    $isNamedRoute = $route && Route::has($route);
    $isActive = $isNamedRoute && Request::routeIs($route) ? 'active' : '';

    // Gunakan named route jika tersedia, jika tidak gunakan URL langsung
    $href = $isNamedRoute ? route($route) : ($route ? url($route) : '#');
@endphp

<li class="{{ $isActive }} {{ $active }} group">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$class group flex items-center rounded-lg px-2 py-1.5 text-foreground hover:bg-secondary hover:text-secondary-foreground " . ($isActive ? 'bg-primary text-primary-foreground' : '')]) }}>
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span class="ms-3 flex-1 whitespace-nowrap">{{ $text }}</span>
        @if ($badge)
            <span class="bg-primary text-primary-foreground ms-3 inline-flex items-center justify-center rounded-full px-2 text-sm font-medium">{{ $badge }}</span>
        @endif
    </a>
</li>
