@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-dark dark:text-light']) }}>
    {{ $value ?? $slot }}
</label>
