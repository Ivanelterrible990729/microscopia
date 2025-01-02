<div class="grid grid-cols-3 gap-4">
    <div class="col-span-3 sm:col-span-1 p-5">
        <div class="flex items-center">
            <x-base.lucide
                icon="shield-ellipsis"
                class="w-14 h-14 mr-2"
            />
            <h2 class="mr-auto text-2xl font-medium">
                {{ $role->name }}
            </h2>
        </div>
    </div>
    <div class="col-span-3 sm:col-span-1 border-t sm:border-t-0 border-l-0 sm:border-l p-5">
        <div class="text-center sm:text-left">
            <h3 class="text-base font-medium mb-5">{{ __('Details') }}</h3>

            <div class="mb-2">
                <b>{{ __('Created at') }}:</b>
                <span>{{ $role->created_at }}</span>
            </div>
            <div class="mb-2">
                <b>{{ __('Updated at') }}:</b>
                <span>{{ $role->updated_at }}</span>
            </div>
        </div>
    </div>
    <div class="col-span-3 sm:col-span-1 border-t sm:border-t-0 border-l-0 sm:border-l p-5">
        <div class="text-center sm:text-right">
            <x-base.button
                x-on:click="modoEdicion = true"
                class="px-4 py-3 align-top mr-2"
                variant="warning"
            >
                <x-base.lucide
                    icon="edit"
                    class="mr-2"
                />
                {{ __('Edit') }}
            </x-base.button>
            <x-base.button
                class="px-4 py-3 align-top"
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
