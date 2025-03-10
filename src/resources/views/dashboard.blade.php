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
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="microscope"
            class="h-6 w-6 mr-2"
        />
        <h2 class="mr-auto text-xl font-medium">
            {{ config('app.name') }}
        </h2>
    </div>

    <livewire:dashboard.images-count />

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-8">
            <livewire:dashboard.image-increase />
        </div>

        <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-4">
            <livewire:dashboard.labels-distribution />
        </div>
    </div>
@endsection

@pushOnce('scripts')
    @vite('resources/js/utils/colors.js')
    @vite('resources/js/components/donut-chart.js')
    @vite('resources/js/components/line-chart.js')
@endPushOnce
