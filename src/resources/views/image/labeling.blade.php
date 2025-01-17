@extends('../theme/main-layout')

@section('subhead')
    <title>{{ config('app.name') }} - {{ __('Image labeling') }}</title>
@endsection

@section('breadcrumb')
    <x-base.breadcrumb class='h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6' light>
        <x-base.breadcrumb.link :index="0" href="{{ route('image.index') }}">
            {{ __('Image management') }}
        </x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" :active="true" href="{{ route('image.labeling', implode(',', $images->pluck('id')->toArray())) }}">
            {{ __('Image labeling') }}
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
@endsection

@section('subcontent')
    <div class="intro-x mt-8 flex items-center mb-5">
        <x-base.lucide
            icon="tags"
            class="mr-2"
        />
        <h2 class="mr-auto text-lg font-medium">
            {{ __('Image labeling')}}
        </h2>
    </div>

    <div class="intro-y box mt-5 pt-10 lg:pt-14">
        <div class="flex items-center justify-center">
            <x-base.button
                class="intro-y mx-2 h-10 w-10 rounded-full"
                variant="primary"
            >
                1
            </x-base.button>
            <x-base.button
                class="intro-y hidden lg:block mx-2 h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400"
            >
                2
            </x-base.button>
            <x-base.button
                class="intro-y hidden lg:block mx-2 h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400"
            >
                3
            </x-base.button>

            <div class="block lg:hidden">...</div>

            <x-base.button
                class="intro-y mx-2 h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400"
            >
                <x-base.lucide
                    icon="check-circle"
                />
            </x-base.button>
        </div>

        <div class="mt-10 px-5">
            <div class="text-center text-lg font-medium">
                Imagen 1
            </div>
            <div class="mt-2 text-base text-center text-slate-500">
                Por favor, complete la información requerida y haga clic en
                <label class="text-blue-500 hover:text-blue-700 underline cursor-pointer" for="next-button">
                    "{{ __('Next') }}"
                </label>.
            </div>
        </div>

        <x-base.dialog.description class="mt10 lg:mt-14 border-t border-slate-200/60 px-4 pt-10 dark:border-darkmode-400 lg:px-10">
            <div class="grid grid-cols-12 gap-6 divide-x-0 lg:divide-x-2">
                <div class="col-span-12 lg:col-span-4 mr-0 lg:mr-2">
                    <x-base.image-zoom
                        class="w-full rounded-md"
                        src="{{ Vite::asset('resources/images/dataset/MUSCULO.jpg') }}"
                        alt="Image"
                    />

                    <div class="mt-5">
                        <x-base.form-label for="state.roles">
                            <div class="text-left">
                                <div class="font-medium">{{ __('Predicciones') }}:</div>
                            </div>
                        </x-base.form-label>

                        <div class="border rounded p-5">
                            <div class="flex flex-row items-center justify-between">
                                <div>
                                    Modelo: <span class="font-medium">VGG16</span>
                                </div>
                                <div>
                                    <button
                                        class="flex items-center rounded-md px-3 py-1 hover:bg-slate-200 dark:hover:bg-slate-700 w-max"
                                        href=""
                                    >
                                        <x-base.lucide
                                            class="mr-2 h-4 w-4"
                                            icon="tag"
                                        /> {{__('Agregar esta etiqueta') }}
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 rounded font-medium text-center px-2 py-1" style="border-width: 2px; border-color: #F59E0B; color: #F59E0B">
                                93% MUSCULO
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-8 pl-0 lg:pl-10">
                    <x-base.form-inline
                        class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
                        formInline
                    >
                        <x-base.form-label for="state.roles" class="xl:!mr-10 xl:w-64">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">{{ __('Name') }}</div>
                                </div>
                                <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                    {{ __('Escriba aquí el nombre de la imagen.') }}
                                </div>
                            </div>
                        </x-base.form-label>
                        <div class="mt-3 w-full flex-1 xl:mt-0">
                            <x-base.form-input
                                id="roleForm.role.name"
                                name="roleForm.role.name"
                                required
                                class="block px-4 py-3"
                            />
                        </div>
                    </x-base.form-inline>

                    <x-base.form-inline
                        class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
                        formInline
                    >
                        <x-base.form-label for="state.roles" class="xl:!mr-10 xl:w-64">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">{{ __('Description') }}</div>
                                    <div
                                        class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                        Opcional
                                    </div>
                                </div>
                                <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                    {{ __('En caso de requerirlo, usted puede dar una descripción de la imágen.') }}
                                </div>
                            </div>
                        </x-base.form-label>
                        <div class="mt-3 w-full flex-1 xl:mt-0">
                            <x-base.form-textarea
                                id="roleForm.role.guard_name"
                                name="roleForm.role.guard_name"
                                wire:model='roleForm.role.guard_name'
                                class="block px-4 py-3"
                            />
                        </div>
                    </x-base.form-inline>

                    <div class="mt-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row">
                        <x-base.form-label for="state.roles">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">{{ __('Labels') }}</div>
                                </div>
                                <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                    {{ __('Se enlistan aquí las etiquetas asignadas a la imágen.') }}
                                </div>
                            </div>
                        </x-base.form-label>

                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            @foreach ($images[0]->labels as $label)
                                <span class="mt-2 flex items-center border rounded-md px-3 py-2 w-min">
                                    <div class="mr-3 h-2 w-2 p-1 rounded-full text-xs" style="background-color: {{ $label->color }};"></div>
                                    <span class="mr-2">{{ $label->name }}</span>

                                    <span class="border-l hover:bg-slate-200 dark:hover:bg-slate-700 pl-2">
                                        &times;
                                    </span>
                                </span>
                            @endforeach

                            <button
                                class="mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-max"
                                href=""
                            >
                                <x-base.lucide
                                    class="mr-2 h-4 w-4"
                                    icon="tag"
                                /> {{__('Agregar etiqueta') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </x-base.dialog.description>

        <x-base.dialog.footer class="intro-y col-span-12 mt-5 flex items-center justify-center sm:justify-end">
            <x-base.button
                class="w-24"
                variant="secondary"
            >
                Previous
            </x-base.button>
            <x-base.button
                id="next-button"
                class="ml-2 w-24 focus:border-green-600 focus:border-2 focus:ring-2 focus:ring-green-300"
                variant="primary"
            >
                {{ __('Next') }}
            </x-base.button>
        </x-base.dialog.footer>
    </div>
@endsection
