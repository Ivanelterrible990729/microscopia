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
                    Opcional
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
        />
    </div>
</x-base.form-inline>

<div class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row">
    <x-base.form-label for="form.labelIds">
        <div class="text-left">
            <div class="flex items-center">
                <div class="font-medium">{{ __('Labels') }}</div>
            </div>
            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                {{ __('Se enlistan aquí las etiquetas asignadas a la imágen.') }}
            </div>
        </div>
    </x-base.form-label>

    <div class="flex flex-col sm:flex-row items-center gap-4">
        @foreach ($images[$activeIndex]->labels as $label)
            <span class="mt-2 flex items-center border rounded-md px-3 py-2 w-min">
                <div class="mr-3 h-2 w-2 p-1 rounded-full text-xs" style="background-color: {{ $label->color }};"></div>
                <span class="mr-2">{{ $label->name }}</span>

                <span class="border-l hover:bg-slate-200 dark:hover:bg-slate-700 pl-2">
                    &times;
                </span>
            </span>
        @endforeach

        <button
            class="mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-max"
            href=""
        >
            <x-base.lucide
                class="mr-2 h-4 w-4"
                icon="tag"
            /> {{__('Agregar etiqueta') }}
        </button>
    </div>
</div>
