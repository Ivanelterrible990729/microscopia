<div>
    <div class="intro-y box mt-5 pt-10 lg:pt-14">
        <div class="flex items-center justify-center">

            @foreach ($imageForms as $index => $imageForm)
                <x-base.button
                    @class([
                        'intro-y hidden lg:block mx-2 h-10 w-10 rounded-md bg-slate-300 text-slate-700 cursor-pointer' => $index != $activeIndex && $imageForm['reviewed'],
                        'intro-y hidden lg:block mx-2 h-10 w-10 rounded-md bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400 cursor-auto' => $index != $activeIndex && !$imageForm['reviewed'],
                        'intro-y bg-primary border-primary text-white dark:border-primary mx-2 h-10 w-10 rounded-md cursor-pointer' => $index == $activeIndex,
                    ])
                    wire:click='setActiveIndex({{ $index }})'
                >
                    {{ $loop->iteration}}
                </x-base.button>
            @endforeach

            <div class="block lg:hidden">
                ...
            </div>

            <x-base.button
                @class([
                    'intro-y mx-2 h-10 w-10 rounded-md bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400' => $this->activeIndex <= $this->lastIndex,
                    'intro-y bg-primary border-primary text-white dark:border-primary mx-2 h-10 w-10 rounded-md' => $this->activeIndex > $this->lastIndex,
                ])
                wire:click='setActiveIndex({{ $index + 1 }})'
            >
                <x-base.lucide
                    icon="check-circle"
                />
            </x-base.button>
        </div>

        @if ($this->activeIndex <= $this->lastIndex)
            @include('livewire.image.images-wizard.active-form')
        @else
            @include('livewire.image.images-wizard.confirm-wizard')
        @endif
    </div>
</div>
