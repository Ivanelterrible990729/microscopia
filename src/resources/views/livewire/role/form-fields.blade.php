<div class="mt-5 mb-3">
    <x-base.form-label
        for="roleForm.role.name"
    >
        {{ __('Role name') }}
    </x-base.form-label>
    <x-base.form-input
        id="roleForm.role.name"
        name="roleForm.role.name"
        wire:model='roleForm.role.name'
        required
        class="block px-4 py-3"
    />
</div>

<div class="mb-3">
    <x-base.form-label
        for="roleForm.role.guard_name"
    >
        {{ __('Guard name') }}
    </x-base.form-label>
    <x-base.form-input
        id="roleForm.role.guard_name"
        name="roleForm.role.guard_name"
        wire:model='roleForm.role.guard_name'
        required
        class="block px-4 py-3"
    />
</div>
