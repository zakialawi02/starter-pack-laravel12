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
            'base' => 'bg-neutral text-neutral-foreground border border-neutral',
            'hover' => $href ? 'hover:bg-muted/80' : 'enabled:hover:bg-muted/80',
        ],
        'outline' => [
            'base' => 'bg-transparent text-neutral border border-neutral',
            'hover' => $href ? 'hover:bg-neutral hover:text-neutral-foreground' : 'enabled:hover:bg-neutral enabled:hover:text-neutral-foreground',
        ],
    ];

    $baseClasses = $variants[$variant]['base'];
    $hoverClasses = $variants[$variant]['hover'];

    $classes = $baseClasses . ' ' . $hoverClasses . ' focus:ring-neutral/80 rounded-md ' . $sizes[$size] . ' text-center font-medium shadow-xs focus:outline-none focus:ring-1 focus:ring-offset-1 transition ease-in-out duration-150';
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
