@props(['size' => 'normal'])

@php
    $sizes = [
        'small' => 'text-sm px-2.5 py-1.5',
        'normal' => 'text-sm px-4 py-2',
        'large' => 'text-base px-6 py-3',
    ];
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'disabled' => false, 'class' => 'bg-error border border-transparent rounded-md text-white font-medium shadow-xs hover:bg-error/70 active:bg-error/80 focus:outline-none focus:ring-1 focus:ring-red-500 focus:ring-offset-1 transition ease-in-out duration-150 disabled:opacity-40  ' . $sizes[$size]]) }}>
    {{ $slot }}
</button>
