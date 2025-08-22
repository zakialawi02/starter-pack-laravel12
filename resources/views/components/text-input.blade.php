@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'focus:ring-primary  focus:border-primary  block w-full rounded-lg bg-input/50 border border-ring px-2.5 py-2 text-foreground']) }}>
