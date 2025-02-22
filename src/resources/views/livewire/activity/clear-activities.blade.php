<div>
    <div class="p-5 text-center">
        <x-base.lucide
            class="mx-auto mt-3 h-16 w-16 text-danger"
            icon="trash-2"
        />
        <div class="mt-5 text-2xl">{{ __('Clear activity log') }}</div>
        <div class="mt-5 text-slate-500">
            {{ __('Are you sure to clear the existing activities?') }}
        </div>
        <div class="mt-5 text-slate-500 font-bold">
            {{ __('This process cannot be undone.') }}
        </div>

        <div class="grid grid-cols-12 gap-6 my-2">
            <div class="col-span-12 lg:col-span-6">
                <x-base.form-label for="n_days">
                    {{ __('From n days') }}
                </x-base.form-label>
                <x-base.form-input
                    id="n_days"
                    type="number"
                    wire:model='numDays'
                    min="0"
                    max="1000"
                />
            </div>

            <div class="col-span-12 lg:col-span-6">
                <x-base.form-label for="log_name">
                    {{ __('Module') }}
                </x-base.form-label>
                <x-base.form-input
                    id="log_name"
                    wire:model='logName'
                    placeholder="{{ __('Empty to delete all') }}"
                />
            </div>
        </div>
    </div>

    <form wire:submit='clearActivities'>
        <div class="px-5 pb-8 text-center">
            <x-base.button
                class="mr-1 w-24"
                data-tw-dismiss="modal"
                type="button"
                variant="outline-secondary"
            >
                {{ __('Cancel') }}
            </x-base.button>

            <x-base.button
                class="w-24"
                type="submit"
                variant="danger"
            >
                {{ __('Clear') }}
            </x-base.button>
        </div>
    </form>
</div>
