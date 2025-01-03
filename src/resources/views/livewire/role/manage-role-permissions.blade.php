<div>
    <h3 class="text-lg font-medium mb-5">{{ __('Permissions') }}</h3>

    <div class="flex items-center text-slate-500">
        <span>
            <x-base.lucide
                class="h-5 w-5 text-warning"
                icon="Lightbulb"
            />
        </span>
        <div class="ml-2">
            <span>
                {{ __('Select the permissions you want to relate to the role') }}:
            </span>
        </div>
    </div>

    @foreach ($this->groupedPermissions as $prefix => $permissions)
        <h3 class="text-base font-medium uppercase my-5">{{ $prefix }}</h3>

        <div class="grid grid-cols-12 gap-3 px-2 mt-4">
            @foreach ($permissions as $permission)
                <div class="col-span-12 sm:col-span-6 md:col-span-4">
                    <x-base.form-check class="mr-4">
                        <x-base.form-check.input
                            id="selectedPermissions.{{ $permission['id'] }}"
                            type="checkbox"
                            value="{{ $permission['name'] }}"
                            wire:model="selectedPermissions"
                        />
                        <x-base.form-check.label for="selectedPermissions.{{ $permission['id'] }}">
                            {{ $permission['subfix'] }}
                        </x-base.form-check.label>
                    </x-base.form-check>
                </div>
            @endforeach
        </div>
    @endforeach

    @error('selectedPermissions')
        <div class="form-help text-red-600 mt-5">{{ $message }}</div>
    @enderror

    <div class="mt-5 text-right">
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
    </div>
</div>
