<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" />
            <x-base.form-input
                id="current_password"
                type="password"
                name="current_password"
                wire:model="state.current_password"
                autocomplete="current-password"
                class="intro-x mt-1 block min-w-full px-4 py-3 xl:min-w-[450px]"
            />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <x-base.form-input
                id="password"
                type="password"
                name="password"
                wire:model="state.password"
                autocomplete="new-password"
                class="intro-x mt-1 block min-w-full px-4 py-3 xl:min-w-[450px]"
            />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-base.form-input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                wire:model="state.password_confirmation"
                autocomplete="new-password"
                class="intro-x mt-1 block min-w-full px-4 py-3 xl:min-w-[450px]"
            />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
