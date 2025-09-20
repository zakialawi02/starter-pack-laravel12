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
            'base' => 'bg-primary text-primary-foreground border border-primary',
            'hover' => $href ? 'hover:bg-primary/80' : 'enabled:hover:bg-primary/80',
        ],
        'outline' => [
            'base' => 'bg-transparent text-primary border border-primary',
            'hover' => $href ? 'hover:bg-primary hover:text-primary-foreground' : 'enabled:hover:bg-primary enabled:hover:text-primary-foreground',
        ],
    ];

    $baseClasses = $variants[$variant]['base'];
    $hoverClasses = $variants[$variant]['hover'];

    $classes = $baseClasses . ' ' . $hoverClasses . ' focus:ring-primary/80 rounded-md ' . $sizes[$size] . ' text-center font-medium shadow-xs focus:outline-none focus:ring-1 focus:ring-offset-1 transition ease-in-out duration-150';
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
