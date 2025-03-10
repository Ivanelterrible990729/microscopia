<div class="mt-5 mb-3">
    <x-base.form-label
        for="form.name"
    >
        {{ __('Role name') }}
    </x-base.form-label>
    <x-base.form-input
        id="form.name"
        name="form.name"
        wire:model='form.name'
        required
        class="block px-4 py-3"
    />
</div>

<div class="mb-3">
    <x-base.form-label
        for="form.guard_name"
    >
        {{ __('Guard name') }}
    </x-base.form-label>
    <x-base.form-input
        id="form.guard_name"
        name="form.guard_name"
        wire:model='form.guard_name'
        required
        class="block px-4 py-3"
    />
</div>
