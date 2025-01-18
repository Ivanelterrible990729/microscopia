<div class="mt-10 px-5">
    <div class="text-center text-lg font-medium">
        Imagen #{{ $activeForm['id'] }}
    </div>
    <div class="mt-2 text-base text-center text-slate-500">
        Por favor, complete la información requerida y haga clic en
        <label class="text-blue-500 hover:text-blue-700 underline cursor-pointer" for="next-button">
            "{{ __('Next') }}"
        </label>.
    </div>
</div>

<x-base.dialog.description class="mt10 lg:mt-14 border-t border-slate-200/60 px-4 pt-10 dark:border-darkmode-400 lg:px-10">
    <div class="grid grid-cols-12 gap-6 divide-x-0 lg:divide-x-2">
        <div class="col-span-12 lg:col-span-4 mr-0 lg:mr-2">
            @include('livewire.image.images-wizard.active-form.image-preview')
        </div>
        <div class="col-span-12 lg:col-span-8 pl-0 lg:pl-10">
            @include('livewire.image.images-wizard.active-form.form-fields')
        </div>
    </div>
</x-base.dialog.description>

<x-base.dialog.footer class="intro-y col-span-12 mt-5 flex items-center justify-center sm:justify-end">
    @if ($activeIndex > 0)
        <x-base.button
            class="w-24"
            variant="secondary"
        >
            Previous
        </x-base.button>
    @endif

    @if ($activeIndex == count($formImages) - 1)
        <x-base.button
            id="next-button"
            class="ml-2 w-24 focus:border-green-600 focus:border-2 focus:ring-2 focus:ring-green-300"
            variant="primary"
        >
            {{ __('Next') }}
        </x-base.button>
    @else
        <x-base.button
            id="next-button"
            class="ml-2 w-24 focus:border-green-600 focus:border-2 focus:ring-2 focus:ring-green-300"
            variant="primary"
        >
            {{ __('Next') }}
        </x-base.button>
    @endif
</x-base.dialog.footer>
