@php
    use App\Models\CnnModel;
@endphp

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

        @can('create', CnnModel::class)
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
        @endcan
    </div>

    <div class="intro-y box mt-5 p-5">
        <x-base.alert
            class="intro-y relative mb-5"
            variant="secondary"
            dismissible
        >
            <x-base.alert.dismiss-button class="absolute right-0 top-0 text-slate-500 font-bold -mr-0.5">
                &times;
            </x-base.alert.dismiss-button>
            <span class="flex flex-row items-start gap-x-2 mb-3">
                <x-base.lucide
                    class="h-5 w-5 text-warning"
                    icon="info"
                />
                <h2 class="text-base font-medium">{{ __('Instructions') }}</h2>
            </span>

            <ul class="mt-2 list-disc pl-5 text-sm leading-relaxed text-justify text-slate-600 dark:text-slate-500">
                <li>
                    {{ __("In this listing, you can search a model by it's name and filter by labels.") }}
                </li>
                <li>
                    {{ __('Click in any model name in the listing to configure it.') }}
                </li>
                <li>
                    {{ __("For creating a new model, click in 'Create CNN model'.") }}
                </li>
                <li>
                    {{ __("For more information, see the documentation.") }}
                </li>
            </ul>
        </x-base.alert>

        <livewire:tables.cnn-models-table />
    </div>

    <!-- BEGIN: Modals para la gestión de imágenes -->
    @can('create', CnnModel::class)
        @include('cnn-model.modal.modal-create')
    @endcan
@endsection
