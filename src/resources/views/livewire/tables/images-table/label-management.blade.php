@php
    use App\Enums\Permissions\LabelPermission;
@endphp

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
                            @can(LabelPermission::Update)
                                <x-base.menu.item
                                    as="button"
                                    x-on:click="$dispatch('edit-label', { labelId: {{ $label->id }} })"
                                    class="w-full text-warning"
                                >
                                    @include('icons.edit')
                                    {{ __('Edit label') }}
                                </x-base.menu.item>
                            @endcan

                            @can(LabelPermission::Delete)
                                <x-base.menu.item
                                    as="button"
                                    x-on:click="$dispatch('delete-label', { labelId: {{ $label->id }} })"
                                    class="w-full text-danger"
                                >
                                    @include('icons.delete')
                                    {{ __('Delete label') }}
                                </x-base.menu.item>
                            @endcan
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    @endforeach

    @can(LabelPermission::Create)
        <button
            class="mt-2 flex items-center rounded-md px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 w-full"
            onclick="dispatchModal('modal-create-label', 'show')"
        >
            <x-base.lucide
                class="mr-2 h-4 w-4"
                icon="Plus"
            /> {{__('New label') }}
        </button>
    @endcan
</div>
