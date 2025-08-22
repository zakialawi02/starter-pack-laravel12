@props([
    'href' => null,
    'type' => 'button',
    'size' => 'normal',
])

@php
    $sizes = [
        'small' => 'text-sm px-2.5 py-1.5',
        'normal' => 'text-sm px-4 py-2',
        'large' => 'text-base px-6 py-3',
    ];

    // Hover class: berbeda untuk <a> dan <button>
    $hover = $href ? 'hover:bg-error/70' : 'enabled:hover:bg-error/70 ';

    $classes = 'bg-error text-foreground border border-transparent rounded-md text-background font-medium shadow-xs ' . $hover . ' focus:outline-none focus:ring-1 focus:ring-error focus:ring-offset-1 disabled:opacity-40 disabled:cursor-not-allowed ' . $sizes[$size];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
