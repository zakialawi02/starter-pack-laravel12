@props([
    'href' => null,
    'type' => 'button',
    'size' => 'normal',
    'variant' => 'solid',
])

@php
    $sizes = [
        'small' => 'text-sm px-2.5 py-1.5',
        'normal' => 'text-base px-4 py-2',
        'large' => 'text-lg px-6 py-3',
    ];

    $variants = [
        'solid' => [
            'base' => 'bg-error text-neutral border border-error',
            'hover' => $href ? 'hover:bg-error/80' : 'enabled:hover:bg-error/80',
        ],
        'outline' => [
            'base' => 'bg-transparent text-error border border-error',
            'hover' => $href ? 'hover:bg-error hover:text-neutral' : 'enabled:hover:bg-error enabled:hover:text-neutral',
        ],
    ];

    $baseClasses = $variants[$variant]['base'];
    $hoverClasses = $variants[$variant]['hover'];

    $classes = $baseClasses . ' ' . $hoverClasses . ' focus:ring-error/80 rounded-md ' . $sizes[$size] . ' text-center font-medium shadow-xs focus:outline-none focus:ring-1 focus:ring-offset-1 transition ease-in-out duration-150';
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
