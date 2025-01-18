<div>
    <div class="intro-y box mt-5 pt-10 lg:pt-14">
        <div class="flex items-center justify-center">

            @foreach ($formImages as $formImage)
                <x-base.button
                    @class([
                        'intro-y bg-primary border-primary text-white dark:border-primary mx-2 h-10 w-10 rounded-full' => $formImage['id'] == $activeForm['id'],
                        'intro-y hidden lg:block mx-2 h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400' => $formImage['id'] != $activeForm['id']
                    ])
                >
                    {{ $loop->iteration}}
                </x-base.button>
            @endforeach

            <div class="block lg:hidden">...</div>

            <x-base.button
                class="intro-y mx-2 h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400"
            >
                <x-base.lucide
                    icon="check-circle"
                />
            </x-base.button>
        </div>

        @if (isset($activeForm))
            @include('livewire.image.images-wizard.active-form')
        @endif
    </div>
</div>
