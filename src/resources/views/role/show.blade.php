@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Roles') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('role.index') }}">
            {{ __('Roles') }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" :active="true" href="{{ route('role.show', $role) }}">
            {{ $role->name }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="cog"
            class="mr-2"
        />
        <h2 class="mr-auto text-lg font-medium">
            {{ __('Manage Role') }}
        </h2>
    </div>

    <div x-data="{modoEdicion: false}">
        <div class="intro-y box mt-5" x-show="!modoEdicion">
            @include('role.preview.details')
        </div>

        <div class="md:grid md:grid-cols-3 md:gap-6 mt-5" x-show="modoEdicion" x-transition:enter.duration.200ms>
            @can(App\Enums\Permissions\RolePermission::Update)
                <x-section-title>
                    <x-slot name="title">
                        <div class="flex flex-1 items-center">
                            <x-base.lucide
                                icon="edit"
                                class="mr-2"
                            />
                            {{ __('Edit role') }}
                        </div>
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Be sure to spell both the role name and the guard name correctly.') }}
                    </x-slot>
                </x-section-title>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="box">
                        <livewire:role.edit-role :role="$role" />
                    </div>
                </div>
            @endcan
        </div>

        <div class="intro-y box mt-5" x-show="!modoEdicion">
            @can(App\Enums\Permissions\RolePermission::ManagePermissions)
                <livewire:role.manage-role-permissions :role="$role" />
            @endcan
        </div>
    </div>
@endsection

