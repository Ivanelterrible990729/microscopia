<x-base.form-inline
class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
formInline
>
    <x-base.form-label for="form.name" class="xl:!mr-10 xl:w-64">
        <div class="text-left">
            <div class="flex items-center">
                <div class="font-medium">{{ __('Name') }}</div>
            </div>
            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                {{ __('Write here the name of the label.') }}
            </div>
        </div>
    </x-base.form-label>
    <div class="mt-3 w-full flex-1 xl:mt-0">
        <x-base.form-input
            id="form.name"
            name="form.name"
            wire:model='form.name'
            required
            class="block px-4 py-3"
            oninput="this.value = this.value.toUpperCase()"
        />
    </div>
</x-base.form-inline>

<x-base.form-inline
class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
formInline
>
    <x-base.form-label for="form.description" class="xl:!mr-10 xl:w-64">
        <div class="text-left">
            <div class="flex items-center">
                <div class="font-medium">{{ __('Description') }}</div>
                <div
                    class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                    {{ __('Optional') }}
                </div>
            </div>
            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                {{ __('If necessary, you can provide a description for this label.') }}
            </div>
        </div>
    </x-base.form-label>
    <div class="mt-3 w-full flex-1 xl:mt-0">
        <x-base.form-textarea
            id="form.description"
            name="form.description"
            wire:model='form.description'
            class="block px-4 py-3"
            rows="4"
        />
    </div>
</x-base.form-inline>

<x-base.form-inline
class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
formInline
>
    <x-base.form-label for="form.color" class="xl:!mr-10 xl:w-64">
        <div class="text-left">
            <div class="flex items-center">
                <div class="font-medium">{{ __('Color') }}</div>
            </div>
            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                {{ __('Please select a color for this label') }}
            </div>
        </div>
    </x-base.form-label>
    <div class="mt-3 w-full flex-1 xl:mt-0">
        <input
            id="form.color"
            name="form.color"
            wire:model="form.color"
            class="w-full cursor-pointer mb-3"
            type="color"
            required
        />

        <label for="form.color" class="bg-secondary/70 border-secondary/70 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400 dark:text-slate-300 cursor-pointer rounded px-2 py-1">
            {{ __('Choose color') }}
        </label>
    </div>
</x-base.form-inline>
