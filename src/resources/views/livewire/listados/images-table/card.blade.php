<div class="file box relative rounded-md px-3 pb-5 pt-8 sm:px-5">
    <div class="absolute left-0 top-0 ml-3 mt-3">
        <x-base.form-check.input
            class="border"
            type="checkbox"
            :value="$row->id"
            x-model="selectedImages"
            x-on:change="selectAll = selectedImages.length === {{ $this->getRows->count() }}"
            class="border-2 bg-slate-50"
        />
    </div>

    <a href="{{ route('image.show', $row) }}">
        <div class="relative group zoom-in">
            <x-base.file-icon
                class="mx-auto w-11/12 mt-2"
                src="{{ $row->getFirstMediaUrl(App\Enums\Media\MediaEnum::Images->value, 'preview') }}"
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
            {{ __('Uploaded by') }}:
        </span>
        <span>
            {{ $row->user->prefijo . ' ' . $row->user->name }}
        </span>
    </div>

    <div class="absolute right-0 top-0 ml-auto mr-2 mt-3">
        <x-dropdown align="right" width="60">
            <x-slot name="trigger">
                <button type="button">
                    @include('icons.ellipsis-vertical')
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="w-60">
                    <x-base.menu.item
                        as="button"
                        {{-- wire:click="editLabelsImage('{{ $row->id }}')" --}}
                        x-on:click="$dispatch('edit-labels-image', { imageId: {{ $row->id }} })"
                        class="w-full"
                    >
                        @include('icons.tags')
                        {{ __('Edit labels') }}
                    </x-base.menu.item>
                    <x-base.menu.item
                        as="a"
                        href="{{ route('image.edit', $row) }}"
                        class="text-warning"
                    >
                        @include('icons.edit')
                        {{ __('Edit image') }}
                    </x-base.menu.item>
                    <x-base.menu.item
                        class="text-danger"
                    >
                        @include('icons.delete')
                        {{ __('Delete image') }}
                    </x-base.menu.item>
                </div>
            </x-slot>
        </x-dropdown>
    </div>

    <div class="p-1 w-full rounded-full mt-2"
        style="{{ $row->labels_color }}">
    </div>
</div>
