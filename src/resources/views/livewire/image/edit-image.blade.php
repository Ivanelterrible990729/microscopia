<div>
    <form wire:submit="updateImage">
        <x-base.dialog.description>
            <x-image.form-fields :form="$form" :available-labels="$availableLabels" />
        </x-base.dialog.description>
        <x-base.dialog.footer>
            <x-base.button
                as="a"
                href="{{ route('image.show', $image) }}"
                class="w-24"
                variant="secondary"
            >
                {{ __('Cancel') }}
            </x-base.button>

            <x-base.button
                class="ml-2 w-24 focus:border-green-600 focus:border-2 focus:ring-2 focus:ring-green-300"
                variant="primary"
                type="submit"
            >
                {{ __('Save') }}
            </x-base.button>
        </x-base.dialog.footer>
    </form>
</div>
