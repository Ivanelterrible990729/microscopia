<div>
    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center text-base font-medium">
            <x-base.lucide
                icon="plus"
                class="mr-2"
            />
            {{ __('Create CNN model') }}
        </h2>
    </x-base.dialog.title>

    <form wire:submit="createModel">
        <x-base.dialog.description>
            <x-validation-errors class="mb-5" />

            @include('livewire.cnn-model.form-fields')
        </x-base.dialog.description>

        <x-base.dialog.footer>
            <x-base.button
                class="mr-2"
                data-tw-dismiss="modal"
                type="button"
                variant="secondary"
            >
            <x-base.lucide
                icon="undo-2"
                class="mr-2"
            />
                {{ __('Cancel') }}
            </x-base.button>
            <x-base.button
                type="submit"
                variant="success"
            >
                <x-base.lucide
                    icon="upload"
                    class="mr-2"
                />
                {{ __('Create CNN model') }}
            </x-base.button>
        </x-base.dialog.footer>
    </form>
</div>
