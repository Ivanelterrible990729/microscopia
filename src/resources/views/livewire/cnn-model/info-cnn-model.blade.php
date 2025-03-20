<div>
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

            <div class="mt-2 flex flex-col items-center justify-center lg:items-start">
                <div class="mb-3">
                    <div class="mb-3 text-xs leading-relaxed text-slate-500">
                        {{ __('The model can make predictions for the following labels') }}:
                    </div>

                    <x-label.show-labels :label-ids="$cnnModel->labels->pluck('id')->toArray()" class="pl-3"/>
                </div>
            </div>

            <div class="mt-2 flex flex-col items-center justify-center lg:items-start">
                <div class="mb-3">
                    <div class="mb-2 text-xs leading-relaxed text-slate-500">
                        {{ __('Model metrics') }}:
                    </div>

                    <ul class="list-disc pl-6">
                        <li>
                            <b>Accuracy:</b>
                            <span>{{ $cnnModel->accuracy ?? '0.9930' }}</span>
                        </li>
                        <li>
                            <b>Loss:</b>
                            <span>{{ $cnnModel->loss ?? '0.0992' }}</span>
                        </li>
                        <li>
                            <b>Val. accuracy:</b>
                            <span>{{ $cnnModel->val_accuracy ?? '1.0000' }}</span>
                        </li>
                        <li>
                            <b>Val. loss:</b>
                            <span>{{ $cnnModel->val_loss ?? '0.0716' }}</span>
                        </li>
                    </ul>
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
                    as="button"
                    class="align-top w-32"
                    variant="secondary"
                    wire:click='downloadModel'
                >
                    <x-base.lucide
                        icon="download"
                        class="mr-2"
                    />
                    {{ __('Download') }}
                </x-base.button>
            </div>

            @can('update', $cnnModel)
                <div class="mt-2 flex items-center justify-center lg:justify-start">
                    <x-base.button
                        as="button"
                        onclick="dispatchModal('modal-edit-cnn-model', 'show')"
                        class="align-top w-32"
                        variant="warning"
                    >
                        <x-base.lucide
                            icon="edit"
                            class="mr-2"
                        />
                        {{ __('Edit') }}
                    </x-base.button>
                </div>
            @endcan

            @can('delete', $cnnModel)
                <div class="mt-2 flex items-center justify-center lg:justify-start">
                    <x-base.button
                        as="button"
                        onclick="dispatchModal('modal-delete-cnn-model', 'show')"
                        class="align-top w-32"
                        variant="danger"
                    >
                        <x-base.lucide
                            icon="trash-2"
                            class="mr-2"
                        />
                        {{ __('Delete') }}
                    </x-base.button>
                </div>
            @endcan
        </div>
    </div>
</div>
