@php
    use App\Models\User;
@endphp

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

        @can('create', User::class)
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
                    {{ __('Click in any user name in the listing to configure a user.') }}
                </li>
                <li>
                    {{ __("For creating a new user, click in 'Create user'.") }}
                </li>
                <li>
                    <a href="{{ route('larecipe.show', ['version' => 'usuario', 'page' => 'section/usuarios']) }}" target="_blank" class="text-blue-500">
                        {{ __("For more information, see the documentation.") }}
                    </a>
                </li>
            </ul>
        </x-base.alert>

        <livewire:tables.users-table />
    </div>

    @can('create', User::class)
        <x-base.dialog id="modal-create-user" size="lg" static-backdrop>
            <x-base.dialog.panel>
                <livewire:user.create-user />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan
@endsection
