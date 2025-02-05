<div>
    <div class="p-5 text-center">
        <x-base.lucide
            class="mx-auto mt-3 h-16 w-16 text-danger"
            icon="trash-2"
        />
        <div class="mt-5 text-2xl">{{ __('Delete label') }}</div>
        <div class="mt-5 text-3xl">{{ $label?->name }}</div>
        <div class="mt-5 text-slate-500">
            {{ __('Are you sure you would like to perform this action?') }}
            <br>
            <ul>
                <li>
                    {{ __('Number of images that will lose this label') }}: {{ $numImagesAffected }}
                </li>
                <li>
                    {{ __('Number of models that will lose this label') }}: {{ $numModelsAffected }}
                </li>
            </ul>
            <br>
            <span class="font-medium">{{ __('This process cannot be undone.') }}</span>
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
            wire:click='deleteLabel'
        >
            {{ __('Delete') }}
        </x-base.button>
    </div>
</div>
