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
        <h2 class="mr-auto text-lg font-medium">{{ __('Profile') }}</h2>
    </div>

    <x-base.tab.group>
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box mt-5 px-5 pt-5">
            <div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
                <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
                    <div class="image-fit h-20 w-20 flex-none sm:h-24 sm:w-24 lg:h-32 lg:w-32">
                        <img
                            class="rounded-full"
                            src="{{ $user->profile_photo_url }}"
                            alt="{{ $user->prefijo . ' ' . $user->name }} picture"
                        />
                    </div>
                    <div class="ml-5">
                        <div class="w-24 truncate text-lg font-medium sm:w-40 sm:whitespace-normal">
                            {{ $user->prefijo . ' ' . $user->name }}
                        </div>
                        <div class="text-slate-500">{{ $user->cargo }}</div>
                    </div>
                </div>
                <div
                    class="mt-6 flex-1 border-l border-r border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-t-0 lg:pt-0">
                    <div class="text-center font-medium lg:mt-3 lg:text-left">
                        {{ __('Details') }}
                    </div>
                    <div class="mt-4 flex flex-col items-center justify-center lg:items-start">
                        <div class="flex items-center truncate sm:whitespace-normal">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="Mail"
                            />
                            <span class="font-medium mr-2">
                                {{ __('Email') }}:
                            </span>
                            {{ $user->email}}
                        </div>
                        <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="timer"
                            />
                            <span class="font-medium mr-2">
                                {{ __('Created at') }}:
                            </span>
                            {{ $user->created_at }}
                        </div>
                        <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="timer-reset"
                            />
                            <span class="font-medium mr-2">
                                {{ __('Updated at') }}:
                            </span>
                            {{ $user->updated_at }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 flex-1 border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-0 lg:pt-0">
                    <div class="text-center font-medium lg:mt-3 lg:text-left">
                        {{ __('Actions') }}
                    </div>
                    <div class="mt-2 flex items-center justify-center lg:justify-start">
                        <x-base.button
                            x-on:click="modoEdicion = true"
                            class="align-top w-36"
                            variant="warning"
                        >
                        <x-base.lucide
                            icon="user"
                            class="mr-2"
                        />
                        {{ __('Personify') }}
                    </x-base.button>
                    </div>
                    <div class="mt-2 flex items-center justify-center lg:justify-start">
                        <x-base.button
                            onclick="dispatchModal('modal-delete-role', 'show')"
                            class="align-top w-36"
                            variant="danger"
                        >
                            <x-base.lucide
                                icon="trash-2"
                                class="mr-2"
                            />
                            {{ __('Delete') }}
                        </x-base.button>
                    </div>
                </div>
            </div>
            <x-base.tab.list
                class="flex-col justify-center text-center sm:flex-row lg:justify-start"
                variant="link-tabs"
            >
                <x-base.tab
                    id="activities-tab"
                    :fullWidth="false"
                    selected
                >
                    <x-base.tab.button class="cursor-pointer py-4">
                        {{ __('Activities') }}
                    </x-base.tab.button>
                </x-base.tab>
            </x-base.tab.list>
        </div>
        <!-- END: Profile Info -->

        <x-base.tab.panels class="intro-y mt-5">
            <x-base.tab.panel
                id="activities"
                selected
            >
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: Activities -->
                    <div class="intro-y box col-span-12 lg:col-span-6">
                        <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
                            <h2 class="mr-auto text-base font-medium">
                                {{ __('Activities') }}
                            </h2>
                        </div>
                        <div class="p-5">

                        </div>
                    </div>
                    <!-- END: Top Categories -->
                </div>
            </x-base.tab.panel>
        </x-base.tab.panels>
    </x-base.tab.group>
@endsection
