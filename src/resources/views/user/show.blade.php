@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Users') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('user.index') }}">
            {{ __('Users') }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" :active="true" href="{{ route('user.show', $user) }}">
            {{ $user->name }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <x-base.lucide
            icon="user"
            class="mr-2"
        />
        <h2 class="mr-auto text-lg font-medium">
            {{ __('Profile') }}
        </h2>
    </div>

    <x-base.tab.group>
        <div class="intro-y box mt-5 px-5 pt-5">
            @include('user.preview.details')

            <x-base.tab.list
                class="flex-col justify-center text-center sm:flex-row lg:justify-start"
                variant="link-tabs"
            >
                <x-base.tab
                    id="configuration-tab"
                    :fullWidth="false"
                    selected
                >
                    <x-base.tab.button class="cursor-pointer py-4">
                        {{ __('Configuration') }}
                    </x-base.tab.button>
                </x-base.tab>
            </x-base.tab.list>
        </div>

        <x-base.tab.panels class="intro-y mt-5">
            <x-base.tab.panel
                id="configuration"
                selected
            >
                <div class="grid grid-cols-12 gap-6">
                    <div class="intro-y box col-span-12 lg:col-span-9">
                        <livewire:user.configure-user :user="$user" />
                    </div>

                    <div class="intro-y hidden lg:block col-span-3">
                        <x-base.alert
                            class="intro-y relative mb-5"
                            variant="soft-warning"
                            dismissible
                        >
                            <x-base.alert.dismiss-button class="absolute right-0 top-0 text-slate-500 font-bold -mr-0.5">
                                &times;
                            </x-base.alert.dismiss-button>

                            <x-base.lucide
                                class="absolute left-0 top-0 mt-5 h-12 w-12 text-warning/80"
                                icon="Lightbulb"
                            />

                            <div class="text-slate-600 dark:text-slate-500 ml-8 mt-2">
                                <span>
                                    {{ __('Configure the user for each of the fields set.') }}
                                </span>
                            </div>
                        </x-base.alert>
                    </div>
                </div>
            </x-base.tab.panel>
        </x-base.tab.panels>
    </x-base.tab.group>
@endsection
