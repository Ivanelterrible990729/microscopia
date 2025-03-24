@php
    use Spatie\Activitylog\Models\Activity;
@endphp

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

        @can('clearActivityLog', Activity::class)
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
                    {{ __("In this listing, you can search a log by it's module, causer and description. You can filter by user and range date.") }}
                </li>
                <li>
                    {{ __('Click in any log ID in the listing to see more details.') }}
                </li>
                <li>
                    <a href="{{ route('larecipe.show', ['version' => 'usuario', 'page' => 'section/registro-actividad']) }}" class="text-blue-500">
                        {{ __("For more information, see the documentation.") }}
                    </a>
                </li>
            </ul>
        </x-base.alert>

        <livewire:tables.activities-table />
    </div>

    <x-base.slideover id="slide-activity-details" size="lg">
        <x-base.slideover.panel>
            <livewire:activity.show-activity-detail />
        </x-base.slideover.panel>
    </x-base.slideover>

    @can('clearActivityLog', Activity::class)
        <x-base.dialog id="modal-clear-activities" size="lg">
            <x-base.dialog.panel>
                <livewire:activity.clear-activities />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan
@endsection
