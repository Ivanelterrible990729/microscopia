@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('CNN Models') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('cnn-model.index') }}">
            {{ __('CNN Models') }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" :active="true" href="{{ route('cnn-model.show', $cnnModel) }}">
            {{ $cnnModel->name }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <x-base.lucide
            icon="brain-circuit"
            class="mr-2"
        />
        <h2 class="mr-auto text-lg font-medium">
            {{ __('CNN Model') }}
        </h2>
    </div>

    <x-base.tab.group>
        <div class="intro-y box mt-5 px-5 pt-5">
            @include('cnn-model.preview.details')

            <x-base.tab.list
                class="flex-col justify-center text-center sm:flex-row lg:justify-start"
                variant="link-tabs"
            >
                <x-base.tab
                    id="training-tab"
                    :fullWidth="false"
                    selected
                >
                    <x-base.tab.button class="flex items-center cursor-pointer py-4">
                        <x-base.lucide
                            icon="brain-cog"
                            class="mr-2"
                        />
                        {{ __('Train model') }}
                    </x-base.tab.button>
                </x-base.tab>

                <x-base.tab
                    id="dataset-tab"
                    :fullWidth="false"
                >
                    <x-base.tab.button class="flex items-center cursor-pointer py-4">
                        <x-base.lucide
                            icon="image-down"
                            class="mr-2"
                        />
                        {{ __('Download dataset') }}
                    </x-base.tab.button>
                </x-base.tab>
                <x-base.tab
                    id="code-tab"
                    :fullWidth="false"
                >
                    <x-base.tab.button class="flex items-center cursor-pointer py-4">
                        <x-base.lucide
                            icon="code"
                            class="mr-2"
                        />
                        {{ __('Download code') }}
                    </x-base.tab.button>
                </x-base.tab>
            </x-base.tab.list>
        </div>

        <x-base.tab.panels class="intro-y mt-5">
            <x-base.tab.panel
                id="training"
                selected
            >
                <div class="grid grid-cols-12 gap-6">
                    <div class="intro-y box col-span-12 lg:col-span-9">
                        <livewire:cnn-model.train-cnn-model :cnn-model="$cnnModel"/>
                    </div>
                </div>
            </x-base.tab.panel>
        </x-base.tab.panels>
    </x-base.tab.group>
@endsection
