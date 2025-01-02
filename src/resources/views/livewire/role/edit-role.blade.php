<div>
    <h3 class="text-base font-medium mb-5">
        {{ __('Edit role') }}
    </h3>

    <form wire:submit="updateRole">
        <div class="px-2">
            <x-validation-errors class="mt-8" />

            <div class="mt-8 mb-3">
                <x-base.form-label
                    for="roleForm.role.name"
                >
                    {{ __('Role name') }}
                </x-base.form-label>
                <x-base.form-input
                    id="roleForm.role.name"
                    name="roleForm.role.name"
                    wire:model='roleForm.role.name'
                    required
                    class="block px-4 py-3"
                />
            </div>

            <div class="mb-3">
                <x-base.form-label
                    for="roleForm.role.guard_name"
                >
                    {{ __('Guard name') }}
                </x-base.form-label>
                <x-base.form-input
                    id="roleForm.role.guard_name"
                    name="roleForm.role.guard_name"
                    wire:model='roleForm.role.guard_name'
                    required
                    class="block px-4 py-3"
                />
            </div>

            <div class="text-center sm:text-right mt-5">
                <x-base.button
                    x-on:click="modoEdicion = false"
                    class="px-4 py-3 align-top mr-2"
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
                    class="px-4 py-3 align-top"
                    variant="success"
                    type="submit"
                >
                    <x-base.lucide
                        icon="save"
                        class="mr-2"
                    />
                    {{ __('Update') }}
                </x-base.button>
            </div>
        </div>
    </form>
</div>
