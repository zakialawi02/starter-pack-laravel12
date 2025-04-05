@props(['size' => 'normal'])

@php
    $sizes = [
        'small' => 'text-sm px-2.5 py-1.5',
        'normal' => 'text-sm px-4 py-2',
        'large' => 'text-base px-6 py-3',
    ];
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'disabled' => false, 'class' => 'bg-primary border border-gray-200 dark:border-neutral-800 hover:bg-primary/70 focus:ring-primary/80 dark:bg-primary dark:hover:bg-primary/80 dark:focus:ring-primary rounded-md ' . $sizes[$size] . ' text-center font-medium text-white shadow-xs focus:outline-none focus:ring-1 focus:ring-offset-1 transition ease-in-out duration-150 disabled:opacity-40']) }}>
    {{ $slot }}
</button>
