@props(['disabled' => false, 'size' => 'normal'])

@php
    $sizes = [
        'small' => 'text-sm px-2 py-1.5',
        'normal' => 'text-base px-2.5 py-2',
        'large' => 'text-lg px-3 py-2.5',
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['normal'];
@endphp

<input @disabled($disabled) {{ $attributes->merge(['class' => 'focus:ring-primary focus:border-primary block w-full rounded-lg bg-input border border-ring text-foreground ' . $sizeClasses]) }}>
