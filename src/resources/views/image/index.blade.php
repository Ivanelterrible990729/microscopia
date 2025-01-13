@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Image management') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('image.index') }}">
            {{ __('Image management') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="images"
            class="mr-2"
        />
        <h2 class="mr-auto text-xl font-medium">
            {{ __('Image management') }}
        </h2>

        @can(App\Enums\Permissions\ImagePermission::Upload)
            <x-base.button
                class="shadow-md"
                onclick="dispatchModal('modal-upload-image', 'show')"
                variant="primary"
            >
                <x-base.lucide
                    icon="plus"
                    class="mr-2"
                />
                {{ __('Upload images') }}
            </x-base.button>
            @include('image.modal.modal-upload')
        @endcan
    </div>

    <div x-data="{showGrid: true}">
        <livewire:listados.images-table />
    </div>
@endsection
