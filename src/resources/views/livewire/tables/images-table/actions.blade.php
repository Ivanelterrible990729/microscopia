@php
    use App\Enums\Permissions\ImagePermission;
@endphp

<div :class="{'hidden': selectedImages == 0, 'block': selectedImages > 0 }">
    <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
        <div class="flex items-center">
            <span class="mx-2">{{ __('Selected images') }}:</span>
            <span class="pr-2" x-text="selectedImages.length"></span>
            <button
                x-ref="cancel"
                x-on:click="selectedImages = []; selectAll = false;"
                class="bg-secondary/70 border-secondary/70 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400
                dark:text-slate-300 [&:hover:not(:disabled)]:bg-slate-100 [&:hover:not(:disabled)]:border-slate-100
                [&:hover:not(:disabled)]:dark:border-darkmode-300/80 [&:hover:not(:disabled)]:dark:bg-darkmode-300/80
                border rounded-full text-xs px-2 py-1"
            >
                {{ __('Cancel') }}
            </button>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 space-x-3">
            <x-base.button
                as="button"
                wire:click='imageLabeling'
                class="inline-flex justify-center w-full whitespace-nowrap rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm text-gray-700 hover:bg-gray-50
                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600"
                title="{{ __('You must select a maximum of 12 images to access the labeling wizard.') }}"
            >
                @include('icons.tags')
                {{__('Image labeling')}}
            </x-base.button>

            @if ($filterComponents[uncamelize(__('Images'))] !== 'trashed')
                @can(ImagePermission::Delete)
                    <x-base.button
                        as="button"
                        variant="danger"
                        class="w-full whitespace-nowrap"
                        x-on:click="
                            $dispatch('delete-images', { imageIds: $refs.images.value });
                        "
                    >
                        @include('icons.delete')
                        {{ __('Delete images')}}
                    </x-base.button>
                @endcan
            @else
                @can(ImagePermission::Restore)
                    <x-base.button
                        as="button"
                        variant="danger"
                        class="w-full whitespace-nowrap"
                        x-on:click="
                            $dispatch('restore-images', { imageIds: $refs.images.value });
                        "
                    >
                        @include('icons.delete')
                        {{ __('Restore images') }}
                    </x-base.button>
                @endcan
            @endif

            <input type="hidden" x-ref="images" x-bind:value="selectedImages">
            <div x-on:images-restored.window="$refs.cancel.click();"></div>
            <div x-on:images-deleted.window="$refs.cancel.click();"></div>
        </div>
    </div>
</div>
