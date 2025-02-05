<div>
    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center">
                <x-base.lucide
                icon="tags"
                class="mr-2"
            />
            {{ __('Edit labels') }}
        </h2>
    </x-base.dialog.title>

    <x-base.dialog.description>
        <x-validation-errors class="mb-5" />

        <x-base.form-inline
            class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
            formInline
        >
            <x-base.form-label for="form.labelIds">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium">{{ __('Labels') }}</div>
                        <div
                            class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                            {{ __('Optional') }}
                        </div>
                    </div>
                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                        {{ __('Se enlistan aquí las etiquetas asignadas a la imagen.') }}
                    </div>
                </div>
            </x-base.form-label>
            <div class="mt-3 w-full flex-1 xl:mt-0" wire:key="{{ str()->random(50) }}">
                <x-base.tom-select
                    id="form.labelIds"
                    name="form.labelIds"
                    wire:model='form.labelIds'
                    class="tom-select w-full"
                    :data-placeholder="__('Select one or more labels.')"
                    multiple
                >
                    @foreach ($availableLabels as $label)
                        <option value="{{ $label['id'] }}" @selected(in_array($label['id'], $form->labelIds))>
                            {{ $label['name'] }}
                        </option>
                    @endforeach
                </x-base.tom-select>
            </div>
        </x-base.form-inline>
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
            type="button"
            variant="success"
            wire:click='editLabels'
        >
            <x-base.lucide
                icon="save"
                class="mr-2"
            />
            {{ __('Save') }}
        </x-base.button>
    </x-base.dialog.footer>
</div>


@script
    <script>
        options = {
            valueField: 'id',
            searchField: 'name',
            options: $wire.availableLabels,
            render: {
                option: function (data, escape) {
                    return `<div class="flex items-center">
                                <div class="mr-3 h-2 w-2 p-1 lg:p-0.5 rounded-full text-xs" style="background-color: ${escape(data.color)};"></div>
                                ${escape(data.name)}
                            </div>`;
                },
                item: function (data, escape) {
                    return `<div class="item" data-ts-item>
                                <div class="mr-3 h-2 w-2 p-1 lg:p-0.5 rounded-full text-xs" style="background-color: ${escape(data.color)};"></div>
                                ${escape(data.name)}
                            </div>`;
                },
            },
        }

        window.initTomSelect('.tom-select', options);

        Livewire.hook('morph.updating', () => {
            options.options = $wire.availableLabels,
            window.initTomSelect('.tom-select', options);
        });
    </script>
@endscript
