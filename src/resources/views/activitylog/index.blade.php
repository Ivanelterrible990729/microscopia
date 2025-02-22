@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Activity log') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('activitylog.index') }}">
            {{ __('Activity log') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="square-activity"
            class="mr-2"
        />
        <h2 class="mr-auto text-xl font-medium">
            {{ __('Activity log') }}
        </h2>

        <x-base.button
            class="shadow-md"
            onclick="dispatchModal('modal-clear-activities', 'show')"
            variant="danger"
        >
            <x-base.lucide
                icon="trash-2"
                class="mr-2"
            />
            {{ __('Clear activity log') }}
        </x-base.button>
    </div>

    <div class="intro-y box mt-5 p-5">
        <livewire:tables.activities-table />
    </div>

    <x-base.slideover id="slide-activity-details" size="lg">
        <x-base.slideover.panel>
            <livewire:activity.show-activity-detail />
        </x-base.slideover.panel>
    </x-base.slideover>

    <x-base.dialog id="modal-clear-activities" size="lg">
        <x-base.dialog.panel>
            <livewire:activity.clear-activities />
        </x-base.dialog.panel>
    </x-base.dialog>
@endsection
