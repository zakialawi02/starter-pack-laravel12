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
            'base' => 'bg-secondary text-secondary-foreground border border-secondary',
            'hover' => $href ? 'hover:bg-secondary/80' : 'enabled:hover:bg-secondary/80',
        ],
        'outline' => [
            'base' => 'bg-transparent text-secondary border border-secondary',
            'hover' => $href ? 'hover:bg-secondary hover:text-secondary-foreground' : 'enabled:hover:bg-secondary enabled:hover:text-secondary-foreground',
        ],
    ];

    $baseClasses = $variants[$variant]['base'];
    $hoverClasses = $variants[$variant]['hover'];

    $classes = $baseClasses . ' ' . $hoverClasses . ' focus:ring-secondary/80 rounded-md ' . $sizes[$size] . ' text-center font-medium shadow-xs focus:outline-none focus:ring-1 focus:ring-offset-1 transition ease-in-out duration-150';
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
