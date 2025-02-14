<x-base.dialog.description>
    @if ($cnnModel->hasMedia('*'))
        <div wire:ignore>
            <x-base.alert
                class="intro-y box col-span-11 mb-6 dark:border-darkmode-600"
                variant="warning"
                dismissible
            >
                <div class="flex items-center">
                    <span>
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="octagon-alert"
                        />
                    </span>
                    <span>
                        {{ __('Since this model has been already trained, a model backup will be downloaded at the start of the training process.') }}
                    </span>
                    <x-base.alert.dismiss-button class="text-white">
                        <x-base.lucide
                            class="h-4 w-4"
                            icon="X"
                        />
                    </x-base.alert.dismiss-button>
                </div>
            </x-base.alert>
        </div>
    @endif

    <x-validation-errors class="mb-5"/>


    <div x-data="{
        validationPortion: $wire.entangle('form.validation_portion'),
        selectedLabels: $wire.entangle('form.selected_labels'),
        count: 0,
    }"
    x-init="count = $wire.uploadMinImages();">
        <x-base.form-inline
            class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
            formInline
        >
            <x-base.form-label for="form.selected_model" class="xl:!mr-10 xl:w-64">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium">{{ __('Available models') }}</div>
                    </div>
                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                        {{ __('Choose the model you want to start from the training') }}
                    </div>
                </div>
            </x-base.form-label>
            <div class="mt-3 w-full flex-1 xl:mt-0">
                <x-base.form-select
                    id="form.selected_model"
                    name="form.selected_model"
                    wire:model='form.selected_model'
                >
                    @foreach ($availableModels as $value => $modelName)
                        <option value="{{ $value }}">
                            {{ $modelName }}
                        </option>
                    @endforeach
                </x-base.form-select>
            </div>
        </x-base.form-inline>

        <x-base.form-inline
            class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
            formInline
        >
            <x-base.form-label for="form.selected_labels" class="xl:!mr-10 xl:w-64">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium">{{ __('Training labels') }}</div>
                    </div>
                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                        {{ __('Choose the labels to be used in the training process') }}
                    </div>
                </div>
            </x-base.form-label>
            <div class="mt-3 w-full flex-1 xl:mt-0">
                <div class="grid grid-cols-12 gap-3 px-2 mt-5">
                    <div class="col-span-12 sm:col-span-6">
                        @forelse ($availableLabels as $key => $label)
                            <x-base.form-check>
                                <x-base.form-check.input
                                    id="form.selected_labels.{{ $key }}"
                                    type="checkbox"
                                    value="{{ $label['id'] }}"
                                    x-model="selectedLabels"
                                    x-on:change="count = $wire.uploadMinImages();"
                                />
                                <x-base.form-check.label for="form.selected_labels.{{ $key }}">
                                    <span class="flex items-center">
                                        <div class="mr-3 h-2 w-2 p-1 rounded-full text-xs" style="background-color: {{ $label['color'] }};"></div>
                                        <span>{{ $label['name'] . ' (' . $label['images_count'] . ')' }}</span>
                                    </span>
                                </x-base.form-check.label>
                            </x-base.form-check>
                        @empty
                            <span class="mt-2 flex items-center border rounded-md px-3 py-2">
                                <span>{{ __('No labels available') }}</span>
                            </span>
                        @endforelse
                    </div>
                    <div class="col-span-12 sm:col-span-6 text-center">
                        <div class="mt-5" wire:ignore>
                            {{ __('Maximum number of images per label') }}:
                            <span class="border rounded bg-slate-100 px-1 py-1" x-text="count"></span>
                        </div>
                    </div>
                </div>
            </div>
        </x-base.form-inline>

        <x-base.form-inline
            class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
            formInline
        >
            <x-base.form-label for="form.validation_portion.*" class="xl:!mr-10 xl:w-64">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium">{{ __('Validation portion') }}</div>
                    </div>
                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                        {{ __('Specify the portion of the validation set for the training') }}
                    </div>
                </div>
            </x-base.form-label>
            <div class="mt-3 w-full flex-1 xl:mt-0">
                <x-base.form-input
                    id="form.validation_portion"
                    name="form.validation_portion"
                    x-model='validationPortion'
                    value="0.2"
                    type="number"
                    step="0.1"
                    min="0"
                    max="0.5"
                    required
                />
                <div class="mt-2 text-xs leading-relaxed text-slate-500 text-end">
                    {{ __('This means a portion of') }} <strong x-text="(1.0 - validationPortion) * 100"></strong>% {{ __('of the dataset for training the model') }}
                </div>
            </div>
        </x-base.form-inline>
    </div>
</x-base.dialog.description>

<x-base.dialog.footer>
    <x-base.button
        variant="primary"
        wire:click='trainModel'
    >
        {{ __('Start training') }}
    </x-base.button>
</x-base.dialog.footer>
