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
                {{ __('Type the model name here.') }}
            </div>
        </div>
    </x-base.form-label>
    <div class="mt-3 w-full flex-1 xl:mt-0">
        <x-base.form-input
            id="form.name"
            name="form.name"
            wire:model='form.name'
            required
        />
    </div>
</x-base.form-inline>

<x-base.form-inline
class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
formInline
>
    <x-base.form-label for="form.labelIds" class="xl:!mr-10 xl:w-64">
        <div class="text-left">
            <div class="flex items-center">
                <div class="font-medium">{{ __('Labels') }}</div>
            </div>
            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                {{ __('Indicate here the labels to train the model with.') }}
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

<x-base.form-inline
class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
formInline
>
    <x-base.form-label for="form.labelIds" class="xl:!mr-10 xl:w-64">
        <div class="text-left">
            <div class="flex items-center">
                <div class="font-medium">{{ __('File') }}</div>
                <div
                    class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                    {{ __('Optional') }}
                </div>
            </div>
            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                {{ __('In case you have a trained model, you can upload it directly.') }}
            </div>
        </div>
    </x-base.form-label>
    <div class="mt-3 w-full flex-1 xl:mt-0"
        x-data="{ isDragging: false, uploading: false, progress: 0, uploaded: $wire.entangle('uploaded')}"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false; uploaded = true;"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <div class="flex items-center justify-center w-full">
            <label
                for="form.file"
                class="flex flex-col items-center justify-center w-full h-56 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500"
                :class="{ 'border-blue-500 bg-blue-100': isDragging }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="isDragging = false"
            >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    @if (isset($form->file))
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Uploaded file') }}
                        </p>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">{{ $form->file?->getClientOriginalName() }}</span>
                        </p>
                        <x-base.button
                            type="button"
                            variant="dark"
                            wire:click='replaceFile'
                            x-on:click="uploaded = false"
                        >
                            {{ __('Replace file') }}
                        </x-base.button>
                    @else
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>

                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">{{ __('Click to upload') }}</span>
                        </p>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Or drag and drop your model here') }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('.h5 format') }} ({{ __('Maximum') . ' ' . config('max-file-size.models_desc') }})
                        </p>
                    @endif
                </div>
                <div class="flex flex-col">

                </div>
                <input id="form.file" name='form.file' wire:model='form.file' type="file" class="hidden" x-bind:disabled="uploaded" />
            </label>
        </div>

        <div x-show="uploading">
            <progress max="100" x-bind:value="progress" class="w-full"></progress>
        </div>
    </div>
</x-base.form-inline>

@script
    <script>
        const options = {
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
