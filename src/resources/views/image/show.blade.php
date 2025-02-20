@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Image management') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('image.index') }}">
            {{ __('Image management') }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" :active="true" href="{{ route('image.show', $image) }}">
            {{ $image->name }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col sm:flex-row items-center space-y-3">
        <div class="flex flex-col mr-auto">
            <div class="flex items-center">
                <x-base.lucide
                    icon="image"
                    class="mr-2"
                />
                <h2 class="text-lg font-medium">
                    {{ $image->name }}
                </h2>
            </div>
            <div class="text-black mt-2">
                {{ __('Uploaded by') }}: {{ $image->user->prefijo . ' ' . $image->user->name }}
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 space-x-3" x-data="{}">
            <x-base.button
                as="a"
                href="{{ route('image.edit', $image) }}"
                variant="warning"
            >
                @include('icons.edit')
                {{__('Edit')}}
            </x-base.button>

            <x-base.button
                as="button"
                variant="danger"
                x-on:click="$dispatch('{{ is_null($image->deleted_at) !== 'trashed' ? 'delete-images' : 'restore-images' }}', { imageIds: {{ $image->id }} })"
            >
                @include('icons.delete')
                {{ is_null($image->deleted_at) ? __('Delete') : __('Restore') }}
            </x-base.button>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5 mb-5">
        <div class="col-span-12 sm:col-span-4">
            <div class="box">
                <x-base.dialog.description>
                    <div class="text-center font-medium lg:mt-3 lg:text-left">
                        {{ __('Details') }}
                    </div>

                    <div class="mt-5 mb-3">
                        <span>
                            {{ __('Weight') }}
                        </span>
                        <div class="bg-slate-100 border rounded px-2 py-1">
                            {{ $image->getFirstMedia('*')->human_readable_size }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <span>
                            {{ __('Description') }}
                        </span>
                        <div class="bg-slate-100 border rounded px-2 py-1">
                            {{ $image->description ?? 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odio illum fugiat qui, in mollitia similique dicta architecto ea beatae tempore ex perspiciatis. Delectus rem nostrum ipsa quod esse nulla iste?' }}
                        </div>
                    </div>

                    <x-section-border />

                    <div class="mt-5 mb-3">
                        <div class="font-medium">{{ __('Labels') }}</div>
                        <div class="my-3 text-xs leading-relaxed text-slate-500">
                            {{ __('Se enlistan aquí las etiquetas asignadas a la imagen.') }}
                        </div>

                        <x-label.show-labels :label-ids="$image->labels->pluck('id')->toArray()" class="pl-3">
                            @can(App\Enums\Permissions\ImagePermission::Label)
                                <button
                                    class="mt-2 flex items-center rounded-md px-3 py-1 hover:bg-slate-200 dark:hover:bg-slate-700 w-max"
                                    onclick="dispatchModal('modal-edit-labels', 'show')"
                                    variant="primary"
                                    size="sm"
                                >
                                    <x-base.lucide
                                        icon="tags"
                                        class="mr-2"
                                    />
                                    {{ __('Edit labels') }}
                                </button>
                            @endcan
                        </x-label.show-labels>
                    </div>
                </x-base.dialog.description>
            </div>

            <div class="box mt-5">
                <livewire:image.predict-image :image="$image" :key="$image->id" />
            </div>
        </div>

        <div class="col-span-12 sm:col-span-8">
            <div class="box">
                <x-base.dialog.description>
                    <div class="flex flex-row items-center">
                        <div class="text-center font-medium lg:mt-3 lg:text-left">
                            {{ __('Image') }}
                        </div>

                        <x-base.button
                            size="sm"
                            variant="dark"
                            class="ml-auto"
                        >
                            <x-base.lucide
                                icon="download"
                                class="mr-2"
                            />
                            {{__('Download')}}
                        </x-base.button>
                    </div>

                    <div class=""> {{-- h-96 --}}
                        <x-base.image-zoom
                            class="h-full w-full image-fit rounded-md mt-5"
                            src="{{ $image->getFirstMediaUrl('*') }}"
                            alt="{{ $image->name }}"
                        />
                    </div>

                    <div class="mt-5">
                        Filtros
                    </div>

                    <div class="flex flex-col sm:flex-row items-center space-x-2 space-y-2">
                        <div class="border rounded px-2 py-1">
                            Sin filtros
                        </div>

                        <div class="border rounded px-2 py-1">
                            Detección de bordes
                        </div>

                        <div class="border rounded px-2 py-1">
                            Detección de esquinas
                        </div>

                        <div class="border rounded px-2 py-1">
                            MSRE
                        </div>
                    </div>

                </x-base.dialog.description>
            </div>
        </div>
    </div>

    <!-- BEGIN: Modals para la gestión de imágenes y etiquetas -->
    @can(App\Enums\Permissions\ImagePermission::Label)
        @include('image.modal.modal-edit-labels')
    @endcan
    @can(App\Enums\Permissions\ImagePermission::Delete)
        @include('image.modal.modal-manage-deletion')
    @endcan
@endsection
