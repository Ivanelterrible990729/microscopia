@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Roles') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('roles.index') }}">
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
    </div>

    <div class="intro-y box mt-5 p-5">
        <livewire:listados.roles-table />
    </div>
@endsection
