@props(['icon' => null, 'width' => 24, 'height' => 24])

<div wire:ignore>
    <i
    data-tw-merge
    data-lucide="{{ uncamelize($icon, '-') }}"
    {{ $attributes->class(merge(['stroke-1.5 w-5 h-5', $attributes->whereStartsWith('class')->first()]))->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
    ></i>
</div>

@pushOnce('vendors')
    @vite('resources/js/vendors/lucide.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/components/base/lucide.js')
@endPushOnce
