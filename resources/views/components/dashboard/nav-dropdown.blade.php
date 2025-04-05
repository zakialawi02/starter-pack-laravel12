@props(['icon' => '', 'text' => '...', 'route' => '', 'items' => []])

@php
    // Cek apakah ada child yang aktif
    $isActive = collect($items)->contains(fn($item) => Route::has($item['route']) && Request::routeIs($item['route']));
@endphp

<li class="group">
    <button class="{{ $isActive ? 'open' : '' }} group flex w-full items-center rounded-lg px-2 py-1.5 text-base text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" data-collapse-toggle="dropdown-{{ Str::slug($text) }}" type="button" aria-controls="dropdown-{{ Str::slug($text) }}">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span class="ms-3 flex-1 whitespace-nowrap text-left rtl:text-right">{{ $text }}</span>
        <i class="ri-arrow-down-s-line group-[.open]:rotate-180"></i>
    </button>
    <ul class="{{ $isActive ? '' : 'hidden' }} space-y-0 py-1" id="dropdown-{{ Str::slug($text) }}">
        @foreach ($items as $item)
            <li>
                <a class="{{ Route::has($item['route']) && Request::routeIs($item['route']) ? 'bg-gray-100 dark:bg-gray-700' : '' }} group flex w-full items-center rounded-lg px-2 py-1.5 pl-11 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}">
                    {{ $item['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
