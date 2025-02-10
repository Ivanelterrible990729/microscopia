<div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
    <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
        <div class="image-fit h-20 w-20 flex-none sm:h-24 sm:w-24 lg:h-32 lg:w-32">
            <x-base.lucide
            icon="brain-circuit"
            class="h-20 w-20 sm:h-24 sm:w-24 lg:h-32 lg:w-32 mr-2"
        />
        </div>
        <div class="ml-5">
            <div class="w-24 text-lg font-medium sm:w-40 sm:whitespace-normal">
                {{ $cnnModel->name }}
            </div>
        </div>
    </div>
    <div
        class="mt-6 flex-1 border-l border-r border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-t-0 lg:pt-0">
        <div class="text-center font-medium lg:mt-3 lg:text-left">
            {{ __('Details') }}
        </div>
        <div class="mt-4 flex flex-col items-center justify-center lg:items-start">
            <div class="mt-5 mb-3">
                <div class="font-medium">{{ __('Labels') }}</div>
                <div class="my-3 text-xs leading-relaxed text-slate-500">
                    {{ __('Se enlistan aquí las etiquetas asignadas a la imagen.') }}
                </div>

                <x-image.image-labels :label-ids="$cnnModel->labels->pluck('id')->toArray()">
                </x-image.image-labels>
            </div>
        </div>
    </div>
    <div
        class="mt-6 flex-1 border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-0 lg:pt-0">
        <div class="text-center font-medium lg:mt-3 lg:text-left">
            {{ __('Actions') }}
        </div>
        <div class="mt-2 flex items-center justify-center lg:justify-start">

                <x-base.button
                    class="align-top"
                    variant="dark"
                >
                    <x-base.lucide
                        icon="download"
                        class="mr-2"
                    />
                    {{ __('Download') }}
                </x-base.button>
        </div>
        <div class="mt-2 flex items-center justify-center lg:justify-start">
            <x-base.button
                onclick="dispatchModal('modal-delete-cnn-model', 'show')"
                class="align-top"
                variant="danger"
            >
                <x-base.lucide
                    icon="trash-2"
                    class="mr-2"
                />
                {{ __('Delete') }}
            </x-base.button>
        </div>
    </div>
</div>
