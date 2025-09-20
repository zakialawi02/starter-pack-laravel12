@props([
    'id' => '',
    'icon' => '',
    'text' => 'Accordion',
])

@php
    // Capture the slot content to check for active children
    $slotContent = $slot->__toString();
    // Check if any child items are active by looking for the active class
    $hasActiveChild = strpos($slotContent, 'active') !== false;
@endphp

<li class="hs-accordion{{ $hasActiveChild ? ' active' : '' }}" id="{{ $id }}">
    <button class="hs-accordion-toggle focus:outline-hidden text-foreground hover:bg-foreground/20 flex w-full items-center gap-x-3.5 rounded-lg px-2.5 py-2 text-start text-sm" type="button" aria-expanded="{{ $hasActiveChild ? 'true' : 'false' }}" aria-controls="{{ $id }}-child">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $text }}
        <i class="ri-arrow-up-s-line hs-accordion-active:block ms-auto hidden"></i>
        <i class="ri-arrow-down-s-line hs-accordion-active:hidden ms-auto block"></i>
    </button>

    <div class="hs-accordion-content{{ $hasActiveChild ? '' : ' hidden' }} w-full overflow-hidden transition-[height] duration-300" id="{{ $id }}-child" role="region" aria-labelledby="{{ $id }}">
        <ul class="space-y-1 pt-1">
            {{ $slot }}
        </ul>
    </div>
</li>
