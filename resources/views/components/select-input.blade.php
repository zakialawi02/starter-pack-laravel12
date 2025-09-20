@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'focus:border-primary focus:ring-primary bg-input/50 text-foreground ring-border border-ring block w-full rounded-lg border px-3 py-2 pe-11 text-sm disabled:pointer-events-none disabled:opacity-50']) }}>
    {{ $slot }}
</select>
