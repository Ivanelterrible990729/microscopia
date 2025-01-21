@props(['image' => null])

<div class="flex flex-col sm:flex-row items-center gap-4">
    @forelse ($image->labels as $label)
        <span class="mt-2 flex items-center border rounded-md px-3 py-2 w-min">
            <div class="mr-3 h-2 w-2 p-1 rounded-full text-xs" style="background-color: {{ $label->color }};"></div>
            <span>{{ $label->name }}</span>
        </span>
    @empty
        <span class="mt-2 flex items-center border rounded-md px-3 py-2">
            <span>{{ __('Unlabeled') }}</span>
        </span>
    @endforelse

    <button
        class="mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-max"
        onclick="dispatchModal('modal-add-labels-image', 'show')"
        type="button"
    >
        <x-base.lucide
            class="mr-2 h-4 w-4"
            icon="tag"
        /> {{__('Add label') }}
    </button>
</div>
