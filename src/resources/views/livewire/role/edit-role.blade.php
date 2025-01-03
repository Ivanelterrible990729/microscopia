<div>
    <x-base.dialog.title>
        <h2 class="mr-auto text-base font-medium">
            {{ __('Edit role') }}
        </h2>
    </x-base.dialog.title>

    <form wire:submit="updateRole">
        <x-base.dialog.description>
            @include('livewire.role.form-fields')
        </x-base.dialog.description>

        <x-base.dialog.footer>
            <x-base.button
                    x-on:click="modoEdicion = false"
                    class="mr-2"
                    variant="secondary"
                    type="button"
                >
                    <x-base.lucide
                        icon="undo-2"
                        class="mr-2"
                    />
                    {{ __('Cancel') }}
                </x-base.button>

                <x-base.button
                    variant="success"
                    type="submit"
                >
                    <x-base.lucide
                        icon="save"
                        class="mr-2"
                    />
                    {{ __('Update') }}
                </x-base.button>
        </x-base.dialog.footer>
    </form>
</div>
