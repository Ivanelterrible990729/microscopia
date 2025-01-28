<div>
    <div class="p-5 text-center">
        <x-base.lucide
            class="mx-auto mt-3 h-16 w-16 text-danger"
            icon="trash-2"
        />
        <div class="mt-5 text-2xl">{{ $mode == 'images-deleted' ? __('Image deletion') : __('Image restore') }}</div>
        <div class="mt-5 text-slate-500">
            {{ __('Are you sure you would like to perform this action?') }}
            <br/>
            {{ $mode == 'images-deleted' ? __('Images that are deleted will be sent to the image garbage can.') :  __('Restored images will be displayed again by default.') }}
        </div>
    </div>

    <x-validation-errors class="mb-5" />

    <div class="px-5 pb-8 text-center">
        <x-base.button
            class="mr-1 w-24"
            data-tw-dismiss="modal"
            type="button"
            variant="outline-secondary"
        >
            {{ __('Cancel') }}
        </x-base.button>

        <x-base.button
            class="w-24"
            type="button"
            variant="danger"
            wire:click='performAction'
        >
            {{ $mode == 'images-deleted' ? __('Delete') : __('Restore') }}
        </x-base.button>
    </div>
</div>
