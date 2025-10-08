@props(['items' => []])

<nav aria-label="breadcrumb">
    <ol class="ms-3 flex items-center whitespace-nowrap">
        @if (count($items) > 2)
            <!-- Tampilkan item pertama -->
            <li class="text-foreground/70 flex items-center text-sm">
                {{ Str::limit($items[0]['text'], 25) }}
                <i class="ri-arrow-right-s-line px-1.5"></i>
            </li>

            <!-- Tampilkan separator ... -->
            <li class="text-foreground/70 flex items-center text-sm">
                ...
                <i class="ri-arrow-right-s-line px-1.5"></i>
            </li>

            <!-- Tampilkan item terakhir -->
            <li class="text-foreground/70 truncate text-sm font-semibold" aria-current="page">
                {{ Str::limit(end($items)['text'], 25) }}
            </li>
        @else
            <!-- Jika hanya 3 item atau kurang, tampilkan semuanya -->
            @foreach ($items as $index => $item)
                <li class="text-foreground/70 flex items-center text-sm">
                    {{ Str::limit($item['text'], 25) }} <!-- Diperbaiki di sini -->
                    @unless ($loop->last)
                        <i class="ri-arrow-right-s-line px-1.5"></i>
                    @endunless
                </li>
            @endforeach
        @endif
    </ol>
</nav>
