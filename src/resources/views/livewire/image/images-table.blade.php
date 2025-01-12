<div class="mt-8 grid grid-cols-12 gap-6 mb-5">
    <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
        <!-- BEGIN: File Manager Menu -->
        <div class="intro-y box p-5">
            <div class="mt-1">
                <button
                    @class([
                        'flex items-center rounded-md bg-primary px-3 py-2 font-medium text-white w-full' => $filterComponents[uncamelize(__('Images'))] !== 'trashed',
                        'flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full' => $filterComponents[uncamelize(__('Images'))] === 'trashed',
                    ])
                    wire:click="setFilterImages('active')"
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="Image"
                    /> {{ __('Images') }}
                </button>
                <button
                    @class([
                        'mt-2 flex items-center rounded-md bg-primary px-3 py-2 font-medium text-white w-full' => $filterComponents[uncamelize(__('Images'))] === 'trashed',
                        'mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full' => $filterComponents[uncamelize(__('Images'))] !== 'trashed',
                    ])
                    wire:click="setFilterImages('trashed')"
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="trash-2"
                    /> {{ __('Trash') }}
                </button>
            </div>
            <div class="mt-4 border-t border-slate-200 pt-4 dark:border-darkmode-400">
                <button
                    @class([
                        'flex items-center rounded-md bg-slate-200 dark:bg-slate-700 px-3 py-2 font-medium w-full' => in_array('no_label', $filterComponents[uncamelize(__('Labels'))]),
                        'flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full' => !in_array('no_label', $filterComponents[uncamelize(__('Labels'))]),
                    ])
                    wire:click="setFilterLabels('no_label')"
                >
                    Sin etiquetar
                </button>

                @foreach ($this->labels as $label)
                    <button
                        @class([
                            'mt-2 flex items-center rounded-md bg-slate-200 dark:bg-slate-700 px-3 py-2 font-medium w-full group' => in_array($label->id, $filterComponents[uncamelize(__('Labels'))]),
                            'mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full group' => !in_array($label->id, $filterComponents[uncamelize(__('Labels'))]),
                        ])
                        wire:click="setFilterLabels({{ $label->id }})"
                    >
                        <div class="mr-3 h-2 w-2 p-1 rounded-full text-xs" style="background-color: {{ $label->color }};"></div>
                        <span>{{ $label->name }}</span>
                        <span class="ml-2 rounded border px-2 py-0.5 text-xs text-slate-600 dark:border-darkmode-100/40 dark:text-slate-300">{{ $label->number_images }}</span>

                        <span class="ml-auto hidden group-hover:block">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-ellipsis-vertical">
                                <circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/>
                            </svg>
                        </span>
                    </button>
                @endforeach

                <button
                    class="mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full"
                    href=""
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="Plus"
                    /> {{__('New label') }}
                </button>
            </div>
        </div>
        <!-- END: File Manager Menu -->
    </div>
    <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
        <!-- BEGIN: File Manager Filter -->
        <div class="intro-y">
            <x-livewire-tables::tools>
                <x-livewire-tables::tools.sorting-pills />
                <x-livewire-tables::tools.filter-pills />

                @includeWhen(
                    $this->hasConfigurableAreaFor('before-toolbar'),
                    $this->getConfigurableAreaFor('before-toolbar'),
                    $this->getParametersForConfigurableArea('before-toolbar')
                )

                <x-livewire-tables::tools.toolbar />

                @includeWhen(
                    $this->hasConfigurableAreaFor('after-toolbar'),
                    $this->getConfigurableAreaFor('after-toolbar'),
                    $this->getParametersForConfigurableArea('after-toolbar')
                )
            </x-livewire-tables::tools>
        </div>
        <!-- END: File Manager Filter -->
        <!-- BEGIN: Directory & Files -->
        <div class="intro-y mt-5 grid grid-cols-12 gap-3 sm:gap-6">
            @forelse ($this->getRows as $rowIndex => $row)
                <div class="col-span-12 sm:col-span-6 lg:col-span-4 2xl:col-span-3" x-transition.duration.500ms>
                    <div class="file box relative rounded-md px-3 pb-5 pt-8 sm:px-5">
                        <div class="absolute left-0 top-0 ml-3 mt-3">
                            <x-base.form-check.input
                                class="border"
                                type="checkbox"
                            />
                        </div>

                        <a href="{{ route('image.show', $row) }}">
                            <div class="relative group zoom-in">
                                <x-base.file-icon
                                    class="mx-auto w-11/12 mt-2"
                                    src="{{ Vite::asset('resources/images/dataset/bacilos.jpg') }}"
                                    variant="image"
                                />
                                <span class="hidden group-hover:inline-block absolute inset-x-0 bottom-0 bg-black text-white text-xs px-1 rounded">
                                    {{ $row->labels_desc }}
                                </span>
                            </div>
                        </a>

                        <a
                            class="mt-4 block truncate text-center font-medium"
                            href="{{ route('image.show', $row) }}"
                        >
                            {{ $row->name }}
                        </a>

                        <div class="text-xs text-slate-500 group mt-5">
                            <span class="font-medium">
                                Subido por:
                            </span>
                            <span>
                                {{ $row->user->prefijo . ' ' . $row->user->name }}
                            </span>
                        </div>

                        <div class="absolute right-0 top-0 ml-auto mr-2 mt-3">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <button type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-ellipsis-vertical">
                                            <circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">
                                        <x-base.menu.item>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-square-pen mr-2">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                            </svg>
                                            Edit
                                        </x-base.menu.item>
                                        <x-base.menu.item>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash-2 mr-2">
                                                <path d="M3 6h18"/>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                <line x1="10" x2="10" y1="11" y2="17"/>
                                                <line x1="14" x2="14" y1="11" y2="17"/>
                                            </svg>
                                            Delete
                                        </x-base.menu.item>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <div class="p-1 w-full rounded-full mt-2"
                            style="{{ $row->labels_color }}">
                        </div>
                    </div>
                </div>
            @empty
                <div class="intro-y col-span-12" style="height: 220px">
                    <x-livewire-tables::table.empty />
                </div>
            @endforelse
        </div>
        <!-- END: Directory & Files -->

        <!-- BEGIN: Pagination -->
        @include('livewire.image.pagination')
        <!-- END: Pagination -->
    </div>
</div>
