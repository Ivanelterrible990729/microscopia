@php
    use App\Enums\Permissions\RolePermission;
@endphp


<div class="grid grid-cols-3 gap-4 p-5">
    <div class="col-span-3 lg:col-span-1 p-5">
        <div class="flex flex-1 items-center justify-start sm:justify-center px-5 lg:justify-start pb-10 sm:pb-0">
            <div class="image-fit h-20 w-20 flex-none sm:h-24 sm:w-24 lg:h-32 lg:w-32">
                <x-base.lucide
                    icon="shield-ellipsis"
                    class="h-20 w-20 sm:h-24 sm:w-24 lg:h-32 lg:w-32 mr-2"
                />
            </div>
            <div class="ml-5">
                <div class="w-24 text-lg font-medium sm:w-40 sm:whitespace-normal">
                    {{ $role->name }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-3 lg:col-span-1 border-t lg:border-t-0 border-l-0 lg:border-l p-5">
        <div class="text-center lg:text-left">
            <div class="text-center font-medium lg:mt-3 lg:text-left">
                {{ __('Details') }}
            </div>

            <div class="mt-4 flex flex-col items-center justify-center lg:items-start">
                <div class="flex items-center truncate sm:whitespace-normal">
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="Mail"
                    />
                    <span class="font-medium mr-2">
                        {{ __('Guard name') }}:
                    </span>
                    {{ $role->guard_name }}
                </div>
                <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="timer"
                    />
                    <span class="font-medium mr-2">
                        {{ __('Created at') }}:
                    </span>
                    {{ $role->created_at }}
                </div>
                <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="timer-reset"
                    />
                    <span class="font-medium mr-2">
                        {{ __('Updated at') }}:
                    </span>
                    {{ $role->updated_at }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-3 lg:col-span-1 border-t lg:border-t-0 border-l-0 lg:border-l p-5">
        <div class="text-center font-medium lg:mt-3 lg:text-left">
            {{ __('Actions') }}
        </div>
        @can(RolePermission::Update)
            <div class="mt-2 flex items-center justify-center lg:justify-start">
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
            </div>
        @endcan
        @can(RolePermission::Delete)
            <div class="mt-2 flex items-center justify-center lg:justify-start">
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
            </div>
        @endcan
    </div>
</div>
