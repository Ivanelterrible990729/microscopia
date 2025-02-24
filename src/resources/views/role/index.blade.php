@php
    use App\Enums\Permissions\RolePermission;
@endphp

@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Roles') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('role.index') }}">
            {{ __('Roles') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="shield-ellipsis"
            class="mr-2"
        />
        <h2 class="mr-auto text-xl font-medium">
            {{ __('Roles') }}
        </h2>

        @can(RolePermission::Create)
            <x-base.button
                onclick="dispatchModal('modal-create-role', 'show')"
                variant="primary"
            >
                <x-base.lucide
                    icon="plus"
                    class="mr-2"
                />
                {{ __('Create role') }}
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
                    {{ __('Click in any ID in the listing to configure a rol.') }}
                </li>
                <li>
                    {{ __("For creating new roles, click in 'new Role'.") }}
                </li>
                <li>
                    {{ __("For more information, see the documentation") }}
                </li>
            </ul>
        </x-base.alert>

        <livewire:tables.roles-table />
    </div>

    @can(RolePermission::Create)
        <x-base.dialog id="modal-create-role" size="md" static-backdrop>
            <x-base.dialog.panel>
                <livewire:role.create-role />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan
@endsection
