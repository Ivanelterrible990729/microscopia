@php
    use App\Enums\Permissions\LabelPermission;
    use App\Enums\Permissions\ImagePermission;
@endphp

@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Image management') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" :active="true" href="{{ route('image.index') }}">
            {{ __('Image management') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="images"
            class="mr-2"
        />
        <h2 class="mr-auto text-xl font-medium">
            {{ __('Image management') }}
        </h2>

        @can(ImagePermission::Upload)
            <x-base.button
                class="shadow-md"
                onclick="dispatchModal('modal-upload-image', 'show')"
                variant="primary"
            >
                <x-base.lucide
                    icon="plus"
                    class="mr-2"
                />
                {{ __('Upload images') }}
            </x-base.button>
        @endcan
    </div>

    <x-base.alert
        class="intro-y relative mt-5 p-5"
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
                {{ __("Here you can create, edit, delete and restore images of this repository.") }}
            </li>
            <li>
                {{ __('Click in any image to see more details.') }}
            </li>
            <li>
                <a href="{{ route('larecipe.show', ['version' => 'usuario', 'page' => 'section/gestion-imagenes']) }}" class="text-blue-500">
                    {{ __("For more information, see the documentation.") }}
                </a>
            </li>
        </ul>
    </x-base.alert>

    <div x-data="{showGrid: true}">
        <livewire:tables.images-table />
    </div>

    <!-- BEGIN: Modals para la gestión de imágenes -->
    @can(ImagePermission::Upload)
        <x-base.dialog id="modal-upload-image" size="xl" static-backdrop>
            <x-base.dialog.panel>
                <livewire:image.upload-images />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan

    @can(ImagePermission::Report)
        <x-base.dialog id="modal-report-images" size="xl" static-backdrop>
            <x-base.dialog.panel>
                <livewire:image.manage-image-report />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan

    @can(ImagePermission::Delete)
        <x-base.dialog id="modal-manage-image-deletion" static-backdrop>
            <x-base.dialog.panel>
                <livewire:image.manage-image-deletion />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan
    <!-- END: Modals para la gestión de imágenes -->

    <!-- BEGIN: Modals para la gestión de etiquetas -->
    @can(LabelPermission::Create)
        <x-base.dialog id="modal-create-label" size="xl" static-backdrop>
            <x-base.dialog.panel>
                <livewire:label.create-label />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan

    @can(LabelPermission::Update)
        <x-base.dialog id="modal-edit-label" size="xl" static-backdrop>
            <x-base.dialog.panel>
                <livewire:label.edit-label />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan

    @can(LabelPermission::Delete)
        <x-base.dialog id="modal-delete-label" static-backdrop>
            <x-base.dialog.panel>
                <livewire:label.delete-label />
            </x-base.dialog.panel>
        </x-base.dialog>
    @endcan
    <!-- END: Modals para la gestión de imágenes -->
@endsection
