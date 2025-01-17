<div class="bg-pending border-pending bg-opacity-20 border-opacity-5 text-pending dark:border-pending dark:border-opacity-20 border rounded p-5">
    <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 space-x-3">
        <span class="font-medium flex items-center text-sm">
            {{ __('Selected images') }}:
            <span class="ml-2" x-text="selectedImages.length"></span>
            <x-base.button
                class="mx-2"
                x-on:click="selectedImages = []; selectAll = false;"
                variant="outline-danger"
                size="sm"
            >
                &times;
            </x-base.button>
        </span>

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
