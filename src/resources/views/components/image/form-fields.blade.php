@props(['form' => null, 'availableLabels' => []])

<div>
    <x-validation-errors class="mb-5"/>

    <x-base.form-inline
        class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
        formInline
    >
        <x-base.form-label for="form.name" class="xl:!mr-10 xl:w-64">
            <div class="text-left">
                <div class="flex items-center">
                    <div class="font-medium">{{ __('Name') }}</div>
                </div>
                <div class="mt-3 text-xs leading-relaxed text-slate-500">
                    {{ __('Escriba aquí el nombre de la imagen.') }}
                </div>
            </div>
        </x-base.form-label>
        <div class="mt-3 w-full flex-1 xl:mt-0">
            <x-base.form-input
                id="form.name"
                name="form.name"
                wire:model='form.name'
                required
                class="block px-4 py-3"
            />
        </div>
    </x-base.form-inline>

    <x-base.form-inline
        class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
        formInline
    >
        <x-base.form-label for="form.description" class="xl:!mr-10 xl:w-64">
            <div class="text-left">
                <div class="flex items-center">
                    <div class="font-medium">{{ __('Description') }}</div>
                    <div
                        class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                        {{ __('Optional') }}
                    </div>
                </div>
                <div class="mt-3 text-xs leading-relaxed text-slate-500">
                    {{ __('En caso de requerirlo, usted puede dar una descripción de la imágen.') }}
                </div>
            </div>
        </x-base.form-label>
        <div class="mt-3 w-full flex-1 xl:mt-0">
            <x-base.form-textarea
                id="form.description"
                name="form.description"
                wire:model='form.description'
                class="block px-4 py-3"
                rows="4"
            />
        </div>
    </x-base.form-inline>

    <x-base.form-inline
        class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
        formInline
    >
        <x-base.form-label for="form.labelIds" class="xl:!mr-10 xl:w-64">
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
        <div class="mt-3 w-full flex-1 xl:mt-0" wire:ignore>
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
    </script>
@endscript
