@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Image management') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('image.index') }}">
            {{ __('Image management') }}
        </x-base.breadcrumb.link>
        {{-- <x-base.breadcrumb.link :index="1" :active="true" href="{{ route('image.show', $image) }}">
            {{ $image->name }}
        </x-base.breadcrumb.link> --}}
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-x mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="user"
            class="mr-2"
        />
        <h2 class="mr-auto text-lg font-medium">
            Etiquetar imágenes
        </h2>
    </div>

    @foreach ($images as $image)
        <div class="md:grid md:grid-cols-3 md:gap-6 mt-5 box p-5">
            <x-section-title>
                <x-slot name="title">
                    Imagen {{ $image->id }}
                </x-slot>

                <x-slot name="description">

                        <x-base.image-zoom
                            class="w-full rounded-md"
                            src="{{ $image->getFirstMediaUrl(App\Enums\Media\MediaEnum::Images->value) }}"
                            alt="{{ $image->name }}"
                        />

                        <div class="mb-3">
                            Predicciones:

                            <div class="border rounded p-5">
                                Modelo: VGG16

                                <br>

                                Predicción: BACILOS
                            </div>
                        </div>
                </x-slot>
            </x-section-title>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="">
                    <x-base.dialog.description>
                        <div class="mt-5 mb-3">
                            <x-base.form-label
                                for="roleForm.role.name"
                            >
                                {{ __('Name') }}
                            </x-base.form-label>
                            <x-base.form-input
                                id="roleForm.role.name"
                                name="roleForm.role.name"
                                wire:model='roleForm.role.name'
                                required
                                class="block px-4 py-3"
                            />
                        </div>

                        <div class="mb-3">
                            <x-base.form-label
                                for="roleForm.role.guard_name"
                            >
                                {{ __('Description') }}
                            </x-base.form-label>
                            <x-base.form-textarea
                                id="roleForm.role.guard_name"
                                name="roleForm.role.guard_name"
                                wire:model='roleForm.role.guard_name'
                                required
                                class="block px-4 py-3"
                            />
                        </div>
                        <p class="mt-2 text-center">{{ $image->name }}</p>

                        <div>
                            Etiquetas:
                        </div>

                        <div>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem quod cum consequatur dolorem debitis iure? Aliquid laudantium eos nisi architecto quod esse? Cum, adipisci nesciunt animi itaque nisi aliquid deleniti.
                        </div>
                    </x-base.dialog.description>
                </div>
            </div>
        </div>

        <x-section-border />
    @endforeach
@endsection
