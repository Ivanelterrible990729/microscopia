@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Image management') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('image.index') }}">
            {{ __('Image management') }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" href="{{ route('image.show', $image) }}">
            {{ $image->name }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="2" :active="true" href="{{ route('image.edit', $image) }}">
            {{ __('Edit') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="image"
            class="mr-2"
        />
        <h2 class="mr-auto text-lg font-medium">
            {{ __('Edit image') }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 divide-x-0 lg:divide-x-2">
        <div class="col-span-12 lg:col-span-8 mr-0 lg:mr-2">
            <div class="intro-y box">
                <livewire:image.edit-image :image="$image" />
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4 pl-0 lg:pl-10">
            <x-image.image-preview :image="$image" />
        </div>
    </div>
@endsection
