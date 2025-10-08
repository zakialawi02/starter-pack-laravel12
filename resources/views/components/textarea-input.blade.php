<textarea {{ $attributes->merge([
    'class' => 'focus:ring-primary focus:border-primary block w-full rounded-lg border border-ring bg-input px-2.5 py-2 text-foreground ',
]) }}>{{ $slot }}</textarea>
