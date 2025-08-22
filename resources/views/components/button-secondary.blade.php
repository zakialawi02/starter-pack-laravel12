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

    // Hover class: beda untuk anchor dan button
    $hover = $href ? 'hover:bg-secondary' : 'enabled:hover:bg-secondary/70 ';

    $classes = 'bg-secondary text-secondary-foreground border border-secondary rounded-md text-center font-medium ' . $sizes[$size] . ' text-light shadow-xs ' . $hover . ' focus:outline-hidden focus:ring-1 focus:ring-secondary focus:ring-offset-1 disabled:opacity-70 transition ease-in-out duration-150';
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
