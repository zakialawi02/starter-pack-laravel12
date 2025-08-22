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

    // Hover class tergantung elemen
    $hover = $href ? 'hover:bg-primary/80' : 'enabled:hover:bg-primary/80';

    $classes = 'bg-primary text-primary-foreground border border-primary ' . $hover . ' focus:ring-primary/80 rounded-md text-primary-foreground ' . $sizes[$size] . ' text-center font-medium text-light shadow-xs focus:outline-none focus:ring-1 focus:ring-offset-1 transition ease-in-out duration-150';
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
