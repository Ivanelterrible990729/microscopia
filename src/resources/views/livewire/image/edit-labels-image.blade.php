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
            <div class="mt-3 w-full flex-1 xl:mt-0">
                <x-base.multi-select
                    :options="$this->availableLabels"
                    :selected-options="$selectedLabels"
                    :placeholder="__('Select one or more labels.')"
                    id="form.labelIds"
                    name="form.labelIds"
                    wire:model='selectedLabels'
                />
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
            wire:click='addLabel'
        >
            <x-base.lucide
                icon="save"
                class="mr-2"
            />
            {{ __('Save') }}
        </x-base.button>
    </x-base.dialog.footer>
</div>
