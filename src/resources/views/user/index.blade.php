@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Users') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('user.index') }}">
            {{ __('Users') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="users"
            class="mr-2"
        />
        <h2 class="mr-auto text-xl font-medium">
            {{ __('Users') }}
        </h2>

        @can(App\Enums\Permissions\UserPermission::Create)
            <x-base.button
                onclick="dispatchModal('modal-create-user', 'show')"
                variant="primary"
            >
                <x-base.lucide
                    icon="plus"
                    class="mr-2"
                />
                {{ __('Create user') }}
            </x-base.button>

            @include('user.modal.modal-create')
        @endcan
    </div>

    <div class="intro-y box mt-5 p-5">
        <livewire:tables.users-table />
    </div>
@endsection
