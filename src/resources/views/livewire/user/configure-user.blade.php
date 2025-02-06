<div>
    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center text-base font-medium">
            <x-base.lucide
                icon="cog"
                class="mr-2"
            />
            {{ __('Configuration') }}
        </h2>
    </x-base.dialog.title>
    <x-base.dialog.description>
        <x-validation-errors class="mb-5" />

        <x-base.form-inline
            class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
            formInline
        >
            <x-base.form-label for="state.roles" class="xl:!mr-10 xl:w-64">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium">{{ __('Roles') }}</div>
                    </div>
                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                        {{ __('You can assign different roles to the specified user.') }}
                    </div>
                </div>
            </x-base.form-label>
            <div class="mt-3 w-full flex-1 xl:mt-0" wire:ignore>
                <x-base.tom-select
                    id="state.roles"
                    name="state.roles"
                    wire:model='state.roles'
                    class="tom-select w-full"
                    :data-placeholder="__('Select one or more roles.')"
                    multiple
                >
                    @foreach ($availableRoles as $role)
                        <option value="{{ $role['id'] }}" @selected(in_array($role['id'], $state['roles']))>
                            {{ $role['name'] }}
                        </option>
                    @endforeach
                </x-base.tom-select>
            </div>
        </x-base.form-inline>
    </x-base.dialog.description>
    <x-base.dialog.footer>
        @can('assignRoles', $user)
            <x-base.button
                variant="success"
                wire:click='save'
            >
                <x-base.lucide
                    icon="save"
                    class="mr-2"
                />
                {{ __('Save') }}
            </x-base.button>
        @endcan
    </x-base.dialog.footer>
</div>

@script
    <script>
        window.initTomSelect('.tom-select');

        Livewire.hook('morph.updating', () => {
            window.initTomSelect('.tom-select');
        });
    </script>
@endscript

