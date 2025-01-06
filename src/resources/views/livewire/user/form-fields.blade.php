<div class="grid grid-cols-12 gap-4 mt-5" x-data="{ showPassword: true }">
    <div class="col-span-4 mb-3">
        <x-base.form-label
            for="user.prefijo"
        >
            {{ __('Prefix') }}
        </x-base.form-label>
        <x-base.form-input
            type="text"
            id="user.prefijo"
            name="user.prefijo"
            wire:model='user.prefijo'
            autocomplete="prefijo"
            class="block px-4 py-3"
        />
    </div>

    <div class="col-span-8 mb-3">
        <x-base.form-label
            for="user.name"
        >
            {{ __('Name') }}
        </x-base.form-label>
        <x-base.form-input
            type="text"
            id="user.name"
            name="user.name"
            wire:model='user.name'
            autocomplete="name"
            required
            class="block px-4 py-3"
        />
    </div>

    <div class="col-span-12 sm:col-span-9 mb-3">
        <x-base.form-label
            for="user.cargo"
        >
            {{ __('Job title') }}
        </x-base.form-label>
        <x-base.form-input
            type="text"
            id="user.cargo"
            name="user.cargo"
            wire:model='user.cargo'
            autocomplete="cargo"
            class="block px-4 py-3"
        />
    </div>

    <div class="col-span-12 sm:col-span-9 mb-3">
        <x-base.form-label
            for="user.email"
        >
            {{ __('Email') }}
        </x-base.form-label>
        <x-base.form-input
            type="email"
            id="user.email"
            name="user.email"
            wire:model='user.email'
            autocomplete="username"
            required
            class="block px-4 py-3"
        />
    </div>

    <div class="col-span-8 mb-3">
        <x-base.form-label
            for="user.password"
        >
            {{ __('Password') }}
        </x-base.form-label>
        <x-base.form-input
            x-bind:type="showPassword ? 'text' : 'password'"
            id="user.password"
            name="user.password"
            wire:model='user.password'
            autocomplete="new-password"
            required
            class="block min-w-full px-4 py-3 xl:min-w-[350px] mr-2 mb-2"
        />

        <x-base.form-check.input
            class="mr-2 border"
            id="show-password"
            name="show-password"
            type="checkbox"
            x-model="showPassword"
        />
        <label class="cursor-pointer select-none" for="show-password">
            {{ __('Show password') }}
        </label>
    </div>

    <div class="col-span-4 mb-3 flex items-center">
        <x-base.button
            type="button"
            class="px-4 py-3"
            variant="sencondary"
            wire:click='generateRandomPassword'
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="mr-0 sm:mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-ccw"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
            <span class="hidden sm:block">
                {{ __('Generate again') }}
            </span>
        </x-base.button>
    </div>

    <div class="col-span-12 sm:col-span-8 mb-3">
        <x-base.form-label
            for="user.password"
        >
            {{ __('Confirm Password') }}
        </x-base.form-label>
        <x-base.form-input
            x-bind:type="showPassword ? 'text' : 'password'"
            id="user.password_confirmation"
            name="user.password_confirmation"
            wire:model='user.password_confirmation'
            autocomplete="new-password"
            required
            class="block px-4 py-3"
        />
    </div>
</div>
