@props(['icon' => '', 'text' => '...', 'route' => '', 'items' => []])

@php
    // Cek apakah ada child yang aktif
    $isActive = collect($items)->contains(fn($item) => Route::has($item['route']) && Request::routeIs($item['route']));
@endphp

<li class="group">
    <button class="{{ $isActive ? 'open' : '' }} text-foreground hover:bg-secondary hover:text-secondary-foreground group flex w-full items-center rounded-lg px-2 py-1.5 text-base transition duration-75" data-collapse-toggle="dropdown-{{ Str::slug($text) }}" type="button" aria-controls="dropdown-{{ Str::slug($text) }}">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span class="ms-3 flex-1 whitespace-nowrap text-left rtl:text-right">{{ $text }}</span>
        <i class="ri-arrow-down-s-line group-[.open]:rotate-180"></i>
    </button>
    <ul class="{{ $isActive ? '' : 'hidden' }} space-y-0.5 py-1" id="dropdown-{{ Str::slug($text) }}">
        @foreach ($items as $item)
            <li>
                <a class="{{ Route::has($item['route']) && Request::routeIs($item['route']) ? 'bg-primary text-primary-foreground' : 'text-foreground hover:bg-secondary hover:text-secondary-foreground' }} group flex w-full items-center rounded-lg px-2 py-1.5 pl-11 transition duration-75" href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}">
                    {{ $item['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
