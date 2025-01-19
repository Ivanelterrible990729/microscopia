<div class="box p-5">
    <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 space-x-3">
        <div class="flex items-center">
            <span class="mx-2">{{ __('Selected images') }}:</span>
            <span class="pr-2" x-text="selectedImages.length"></span>
            <button
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
                variant="secondary"
            >
                @include('icons.plus')
                {{__('Add labels')}}
            </x-base.button>

            <x-base.button
                variant="warning"
            >
                @include('icons.edit')
                {{__('Edit')}}
            </x-base.button>

            <x-base.button
                variant="danger"
            >
                @include('icons.delete')
                {{__('Delete')}}
            </x-base.button>
        </div>
    </div>
</div>
