<div>
    <div class="box mt-5 pt-10 lg:pt-14">
        <div class="flex items-center justify-center" x-data="{}">

            @foreach ($imageForms as $index => $imageForm)
                <button
                    @class([
                        'intro-y hidden lg:block mx-2 h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400 cursor-auto' => $index != $activeIndex,
                        'intro-y bg-primary border-primary text-white dark:border-primary mx-2 h-10 w-10 rounded-full cursor-auto' => $index == $activeIndex,
                    ])
                >
                    {{ $loop->iteration}}
                </button>
            @endforeach

            <button
                @class([
                    'intro-y hidden lg:block mx-2 h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400 cursor-auto' => $this->activeIndex <= $this->lastIndex,
                    'intro-y bg-primary border-primary text-white dark:border-primary mx-2 h-10 w-10 rounded-full cursor-auto' => $this->activeIndex > $this->lastIndex,
                ])
            >
                <x-base.lucide
                    icon="check-circle"
                    class="w-10"
                />
            </button>
        </div>

        <div x-show="$wire.activeIndex <= $wire.lastIndex">
            @include('livewire.image.images-wizard.active-form')
        </div>
        <div x-show="$wire.activeIndex > $wire.lastIndex">
            @include('livewire.image.images-wizard.confirm-wizard')
        </div>
    </div>
</div>
