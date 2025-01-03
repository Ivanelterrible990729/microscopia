<div class="grid grid-cols-3 gap-4 p-5">
    <div class="col-span-3 lg:col-span-1 p-5">
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
    <div class="col-span-3 lg:col-span-1 border-t lg:border-t-0 border-l-0 lg:border-l p-5">
        <div class="text-center lg:text-left">
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
    <div class="col-span-3 lg:col-span-1 border-t lg:border-t-0 border-l-0 lg:border-l p-5">
        <div class="text-center">
            <x-base.button
                x-on:click="modoEdicion = true"
                class="align-top mr-2"
                variant="warning"
            >
                <x-base.lucide
                    icon="edit"
                    class="mr-2"
                />
                {{ __('Edit') }}
            </x-base.button>
            <x-base.button
                onclick="dispatchModal('modal-delete-role', 'show')"
                class="align-top"
                variant="danger"
            >
                <x-base.lucide
                    icon="trash-2"
                    class="mr-2"
                />
                {{ __('Delete') }}
            </x-base.button>

            @include('role.modal.modal-delete')
        </div>
    </div>
</div>
