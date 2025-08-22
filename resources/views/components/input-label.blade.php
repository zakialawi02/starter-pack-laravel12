@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-1.5 block font-medium text-sm text-base-content']) }}>
    {{ $value ?? $slot }}
</label>
