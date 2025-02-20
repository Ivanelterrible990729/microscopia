@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('CNN Models') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('cnn-model.index') }}">
            {{ __('CNN Models') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="brain-circuit"
            class="mr-2"
        />
        <h2 class="mr-auto text-xl font-medium">
            {{ __('CNN Models') }}
        </h2>

        @if($canCreateModel)
            <x-base.button
                class="shadow-md"
                onclick="dispatchModal('modal-create-cnn-model', 'show')"
                variant="primary"
            >
                <x-base.lucide
                    icon="plus"
                    class="mr-2"
                />
                {{ __('Create CNN model') }}
            </x-base.button>
        @endif
    </div>

    <div class="intro-y box mt-5 p-5">
        <livewire:tables.cnn-models-table />
    </div>

    <!-- BEGIN: Modals para la gestión de imágenes -->
    @if($canCreateModel)
        @include('cnn-model.modal.modal-create')
    @endif
@endsection
