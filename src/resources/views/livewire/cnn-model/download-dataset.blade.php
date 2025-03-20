<div>
    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center text-base font-medium">
            <x-base.lucide
                icon="image-down"
                class="mr-2"
            />
            {{ __('Download dataset') }}
        </h2>
    </x-base.dialog.title>

    <x-base.dialog.description>
        <x-validation-errors class="mb-5"/>

        <div x-data="{
            selectedLabels: $wire.entangle('form.selectedLabels'),
            count: 0,
        }"
        x-init="count = $wire.uploadMinImages();"
        >
            <x-base.form-inline
                class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
                formInline
            >
                <x-base.form-label for="form.selectedLabels" class="xl:!mr-10 xl:w-64">
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
                                        id="form.selectedLabels.{{ $key }}.download"
                                        type="checkbox"
                                        value="{{ $label['id'] }}"
                                        x-model="selectedLabels"
                                        x-on:change="count = $wire.uploadMinImages();"
                                    />
                                    <x-base.form-check.label for="form.selectedLabels.{{ $key }}">
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
                <x-base.form-label for="form.allImages" class="xl:!mr-10 xl:w-64">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">{{ __('Download all images') }}</div>
                        </div>
                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                            {{ __('If you want to download all images, feel free to do it.') }}
                        </div>
                    </div>
                </x-base.form-label>
                <div class="mt-3 w-full flex-1 xl:mt-0">
                    <div class="">
                        <x-base.form-check>
                            <x-base.form-check.input
                                id='form.allImages.download'
                                name='form.allImages'
                                type="checkbox"
                                wire:model='form.allImages'
                            />
                            <x-base.form-check.label for="form.allImages">
                                <span>
                                    {{ __('Download all images') }}
                                </span>
                            </x-base.form-check.label>
                        </x-base.form-check>
                    </div>
                </div>
            </x-base.form-inline>

            <x-base.form-inline
                class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
                formInline
            >
                <x-base.form-label for="form.dataAugmentation" class="xl:!mr-10 xl:w-64">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">{{ __('Data augmentation') }}</div>
                        </div>
                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                            {{ __('You can perform some data augmentation actions to enrich the dataset.') }}
                        </div>
                    </div>
                </x-base.form-label>
                <div class="mt-3 w-full flex-1 xl:mt-0">
                    <div class="">
                        <x-base.form-check>
                            <x-base.form-check.input
                                id='form.dataAugmentation.download'
                                name='form.dataAugmentation'
                                type="checkbox"
                                wire:model='form.dataAugmentation'
                            />
                            <x-base.form-check.label for="form.dataAugmentation">
                                <span>
                                    {{ __('Enable data augmentation') }}
                                </span>
                            </x-base.form-check.label>
                        </x-base.form-check>
                    </div>
                </div>
            </x-base.form-inline>
        </div>
    </x-base.dialog.description>

    <x-base.dialog.footer>
        <x-base.button
            variant="primary"
            wire:click='downloadDataset'
        >
            {{ __('Download dataset') }}
        </x-base.button>
    </x-base.dialog.footer>
</div>
