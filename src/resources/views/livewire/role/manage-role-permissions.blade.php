<div>
    @php
        use App\Enums\Permissions\RolePermission;
    @endphp

    <x-base.dialog.title>
        <h3 class="text-base font-medium">{{ __('Permissions') }}</h3>
    </x-base.dialog.title>

    <x-base.dialog.description>
        <div class="flex items-center text-slate-500 mb-5">

        </div>

        <x-base.alert
            class="intro-y relative mb-5"
            variant="secondary"
            dismissible
        >
            <x-base.alert.dismiss-button class="absolute right-0 top-0 text-slate-500 font-bold -mr-0.5">
                &times;
            </x-base.alert.dismiss-button>

            <span class="flex flex-row items-start gap-x-2 mb-3">
                <x-base.lucide
                    class="h-5 w-5 text-warning"
                    icon="info"
                />
                <h2 class="text-base font-medium">{{ __('Instructions') }}</h2>
            </span>
            <div class="ml-2">
                <span>
                    {{ __('Select the permissions you want to relate to the role') }}:
                </span>
            </div>
        </x-base.alert>

        <x-validation-errors class="mb-5" />

        @foreach ($this->groupedPermissions as $prefix => $permissions)
            <h3 class="text-base font-medium uppercase mt-10 mb-5">{{ $prefix }}</h3>

            <div class="grid grid-cols-12 gap-3 px-2 mt-5">
                @foreach ($permissions as $permission)
                    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
                        <x-base.form-check>
                            <x-base.form-check.input
                                id="form.selectedPermissions.{{ $permission['id'] }}"
                                type="checkbox"
                                value="{{ $permission['name'] }}"
                                wire:model="form.selectedPermissions"
                            />
                            <x-base.form-check.label for="form.selectedPermissions.{{ $permission['id'] }}">
                                {{ $permission['subfix'] }}
                            </x-base.form-check.label>
                        </x-base.form-check>
                    </div>
                @endforeach
            </div>
        @endforeach
    </x-base.dialog.description>

    <x-base.dialog.footer>
        @can(RolePermission::ManagePermissions)
            <x-base.button
                wire:click='storePermissions'
                variant="success"
            >
                <x-base.lucide
                    icon="shield-check"
                    class="mr-2"
                />
                {{ __('Relate permissions') }}
            </x-base.button>
        @endcan
    </x-base.dialog.footer>
</div>
