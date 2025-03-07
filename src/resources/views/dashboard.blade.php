@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Dashboard') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('dashboard') }}">
            {{ __('Dashboard') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')

    <livewire:dashboard.images-count />

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-8">
        <div class="intro-y block h-10 items-center sm:flex">
            <h2 class="mr-5 truncate text-lg font-medium">Incremento mensual de imágenes</h2>
            <div class="relative mt-3 text-slate-500 sm:ml-auto sm:mt-0">
                <x-base.lucide
                    class="absolute inset-y-0 left-0 z-10 my-auto ml-3 h-4 w-4"
                    icon="Calendar"
                />
                {{-- <x-base.litepicker
                    class="datepicker !box pl-10 sm:w-56"
                    type="text"
                /> --}}
            </div>
        </div>
        <div class="intro-y box mt-12 p-5 sm:mt-5">
            <div class="flex flex-col md:flex-row md:items-center">
                <div class="flex">
                    <div>
                        <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl">
                            $15,000
                        </div>
                        <div class="mt-0.5 text-slate-500">This Month</div>
                    </div>
                    <div
                        class="mx-4 h-12 w-px border border-r border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5">
                    </div>
                    <div>
                        <div class="text-lg font-medium text-slate-500 xl:text-xl">
                            $10,000
                        </div>
                        <div class="mt-0.5 text-slate-500">Last Month</div>
                    </div>
                </div>
                <x-base.menu class="mt-5 md:ml-auto md:mt-0">
                    <x-base.menu.button
                        class="font-normal"
                        as="x-base.button"
                        variant="outline-secondary"
                    >
                        Filter by Category
                        <x-base.lucide
                            class="ml-2 h-4 w-4"
                            icon="ChevronDown"
                        />
                    </x-base.menu.button>
                    <x-base.menu.items class="h-32 w-40 overflow-y-auto">
                        <x-base.menu.item>PC & Laptop</x-base.menu.item>
                        <x-base.menu.item>Smartphone</x-base.menu.item>
                        <x-base.menu.item>Electronic</x-base.menu.item>
                        <x-base.menu.item>Photography</x-base.menu.item>
                        <x-base.menu.item>Sport</x-base.menu.item>
                    </x-base.menu.items>
                </x-base.menu>
            </div>
            <div @class([
                'relative',
                'before:content-[\'\'] before:block before:absolute before:w-16 before:left-0 before:top-0 before:bottom-0 before:ml-10 before:mb-7 before:bg-gradient-to-r before:from-white before:via-white/80 before:to-transparent before:dark:from-darkmode-600',
                'after:content-[\'\'] after:block after:absolute after:w-16 after:right-0 after:top-0 after:bottom-0 after:mb-7 after:bg-gradient-to-l after:from-white after:via-white/80 after:to-transparent after:dark:from-darkmode-600',
            ])>
                <div class="mt-6">
                    <div class="h-[275px]">
                        <x-base.chart
                            class="line-chart"
                        >
                        </x-base.chart>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-4">
        <livewire:dashboard.images-distribution />
    </div>

        {{-- <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:mt-8">
        <div class="intro-x flex h-10 items-center">
            <h2 class="mr-5 truncate text-lg font-medium">Registro de actividad</h2>
        </div>
        <div class="mt-5">
            <div class="intro-x">
                <div class="box zoom-in mb-3 flex items-center px-5 py-3">
                    <div class="image-fit h-10 w-10 flex-none overflow-hidden rounded-full">
                        <img
                            src="{{ Auth::user()->profile_photo_url }}"
                            alt="Midone - Tailwind Admin Dashboard Template"
                        />
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="mt-0.5 text-xs text-slate-500">
                            {{ now()->format('Y-m-d h:s') }}
                        </div>
                    </div>
                    <div @class([
                        'text-success'
                    ])>
                        {{ __('Image created') }}
                    </div>
                </div>
            </div>

            <a
                class="intro-x block w-full rounded-md border border-dotted border-slate-400 py-3 text-center text-slate-500 dark:border-darkmode-300"
                href=""
            >
                View More
            </a>
        </div>
    </div> --}}
</div>
@endsection

@pushOnce('scripts')
    @vite('resources/js/utils/colors.js')
    @vite('resources/js/components/line-chart.js')
    @vite('resources/js/components/donut-chart.js')
@endPushOnce
