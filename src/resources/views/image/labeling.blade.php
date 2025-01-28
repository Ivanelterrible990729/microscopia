@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Image labeling') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('image.index') }}">
            {{ __('Image management') }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" :active="true" href="{{ route('image.labeling', implode(',', $images->pluck('id')->toArray())) }}">
            {{ __('Image labeling') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-x mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="tags"
            class="mr-2"
        />
        <h2 class="mr-auto text-lg font-medium">
            {{ __('Image labeling')}}
        </h2>
    </div>

    <livewire:image.images-wizard :images="$images" />
@endsection
