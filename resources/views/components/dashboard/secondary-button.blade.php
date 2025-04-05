@props(['size' => 'normal'])

@php
    $sizes = [
        'small' => 'text-sm px-2.5 py-1.5',
        'normal' => 'text-sm px-4 py-2',
        'large' => 'text-base px-6 py-3',
    ];
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'disabled' => false, 'class' => 'bg-secondary border border-gray-300 dark:border-dark-primary/80 rounded-md text-center font-medium ' . $sizes[$size] . ' text-dark shadow-xs hover:bg-secondary/70 focus:outline-hidden focus:ring-1 focus:ring-indigo-500 focus:ring-offset-1  disabled:opacity-40 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
