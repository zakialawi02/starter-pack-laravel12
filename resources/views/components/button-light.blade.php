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
    $hover = $href ? 'hover:bg-base-content/20' : 'enabled:hover:bg-base-content/20';

    $classes = 'bg-neutral text-neutral-foreground border border-neutral ' . $hover . ' focus:ring-neutral/80 rounded-md text-neutral-foreground ' . $sizes[$size] . ' text-center font-medium text-light shadow-xs focus:outline-none focus:ring-1 focus:ring-offset-1 transition ease-in-out duration-150';
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
