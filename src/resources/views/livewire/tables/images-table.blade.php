<div class="mt-8 grid grid-cols-12 gap-6 mb-5" x-data="{ selectedImages: $wire.entangle('selectedImages'), showButton: false, selectAll: false }">
    <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
        <!-- BEGIN: Filter Manager Menu -->
        <div class="intro-y box p-5">
            <div class="mt-1">
                <button
                    @class([
                        'flex items-center rounded-md bg-primary px-3 py-2 font-medium text-white w-full' => $filterComponents[uncamelize(__('Images'))] !== 'trashed',
                        'flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full' => $filterComponents[uncamelize(__('Images'))] === 'trashed',
                    ])
                    wire:click="setFilterImages('active')"
                    x-on:click="$refs.cancel ? $refs.cancel.click() : null"
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
                    x-on:click="$refs.cancel ? $refs.cancel.click() : null"
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="trash-2"
                    /> {{ __('Trash') }}
                </button>
            </div>
            <div class="mt-4 border-t border-slate-200 pt-4 dark:border-darkmode-400 px-1">
                <div class="text-base text-center lg:text-left font-medium lg:mt-3 mb-4">
                    {{ __('Labels') }}
                </div>

                <button
                    @class([
                        'flex items-center rounded-md bg-slate-200 dark:bg-slate-700 px-3 py-2 font-medium w-full' => in_array('unlabeled', $filterComponents[uncamelize(__('Labels'))]),
                        'flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full' => !in_array('unlabeled', $filterComponents[uncamelize(__('Labels'))]),
                    ])
                    wire:click="setFilterLabels('unlabeled')"
                >
                    {{ __('Unlabeled') }}
                </button>

                @foreach ($this->labels as $label)
                    <div
                        @class([
                            'mt-2 flex items-center rounded-md bg-slate-200 dark:bg-slate-700 px-3 py-2 font-medium w-full group cursor-pointer' => in_array($label->id, $filterComponents[uncamelize(__('Labels'))]),
                            'mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full group cursor-pointer' => !in_array($label->id, $filterComponents[uncamelize(__('Labels'))]),
                        ])
                    >
                        <a class="flex items-center w-full" wire:click="setFilterLabels({{ $label->id }})">
                            <div class="mr-3 h-2 w-2 p-1 lg:p-0.5 rounded-full text-xs" style="background-color: {{ $label->color }};"></div>
                            <span>{{ $label->name }}</span>
                        </a>
                        <div class="ml-auto hidden group-hover:block">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <div class="pl-2">
                                        @include('icons.ellipsis-vertical')
                                    </div>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">
                                        <x-base.menu.item
                                            as="button"
                                            x-on:click="$dispatch('edit-label', { labelId: {{ $label->id }} })"
                                            class="w-full text-warning"
                                        >
                                            @include('icons.edit')
                                            {{ __('Edit label') }}
                                        </x-base.menu.item>
                                        <x-base.menu.item
                                            as="button"
                                            x-on:click="$dispatch('delete-label', { labelId: {{ $label->id }} })"
                                            class="w-full text-danger"
                                        >
                                            @include('icons.delete')
                                            {{ __('Delete label') }}
                                        </x-base.menu.item>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endforeach

                <button
                    class="mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full"
                    onclick="dispatchModal('modal-create-label', 'show')"
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="Plus"
                    /> {{__('New label') }}
                </button>
            </div>
        </div>
        <!-- END: Filter Manager Menu -->
        <!-- BEGIN: Tips -->
        <div wire:ignore>
            <x-base.alert
                class="intro-y relative mt-6"
                variant="soft-warning"
                dismissible
            >
                <x-base.alert.dismiss-button class="absolute right-0 top-0 text-slate-500 font-bold -mr-0.5">
                    &times;
                </x-base.alert.dismiss-button>
                <x-base.lucide
                    class="absolute right-0 bottom-2 mt-5 h-12 w-12 text-warning/80"
                    icon="Lightbulb"
                />
                <h2 class="text-base font-medium">Tips</h2>

                <ul class="mt-2 mb-8 list-disc pl-5 text-xs leading-relaxed text-justify text-slate-600 dark:text-slate-500">
                    <li>
                        {{ __('Click on any tag to filter images according to their tags.') }}
                    </li>
                    <li>
                        {{ __('Click on “Trash” to filter images that were deleted.') }}
                    </li>
                    <li>
                        {{ __('Click on the image boxes to select multiple images.') }}
                    </li>
                </ul>
            </x-base.alert>
        </div>
        <!-- END: Tips -->
    </div>
    <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
        <!-- BEGIN: Tools -->
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
        <!-- END: Tools -->

        <!-- BEGIN: Actions -->
        @include('livewire.tables.images-table.actions')
        <!-- END: Actions -->

        <!-- BEGIN: Images grid -->
        <div class="intro-y mt-5 grid grid-cols-12 gap-3 sm:gap-6">
            @forelse ($this->getRows as $rowIndex => $row)
                <div class="col-span-12 sm:col-span-6 lg:col-span-4 2xl:col-span-3" x-transition>
                    @include('livewire.tables.images-table.card')
                </div>
            @empty
                <div class="intro-y col-span-12" style="height: 220px">
                    <x-livewire-tables::table.empty />
                </div>
            @endforelse
        </div>
        <!-- END: Images grid -->

        <!-- BEGIN: Pagination -->
        <template x-if="selectedImages.length == 0">
            @include('livewire.tables.images-table.pagination')
        </template>
        <!-- END: Pagination -->

        <!-- BEGIN: Sroll Button -->
        @include('livewire.tables.images-table.scroll-button')
        <!-- END: Sroll Button -->
    </div>
</div>
