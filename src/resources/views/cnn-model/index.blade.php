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

        {{-- @can(App\Enums\Permissions\ImagePermission::Upload) --}}
            <x-base.button
                class="shadow-md"
                onclick="dispatchModal('modal-upload-cnn-model', 'show')"
                variant="primary"
            >
                <x-base.lucide
                    icon="plus"
                    class="mr-2"
                />
                {{ __('Create CNN model') }}
            </x-base.button>
        {{-- @endcan --}}
    </div>

    <div>

    </div>
@endsection
