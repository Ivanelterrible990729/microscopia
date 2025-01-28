@props(['options ' => [], 'selectedOptions' => [], 'placeholder' => __('Select one or more options.')])

<div
    x-data="{
        open: false,

        selected: {{ json_encode($selectedOptions) }},

        search: '',

        loadOptions(options, selected, search) {
            selected.forEach(element => {
                options = options.filter(o => o.id !== element.id);
            });

            options = options.filter(option => option.name.toLowerCase().includes(search.toLowerCase()));

            return options;
        },
    }"
    x-init="options = loadOptions({{ json_encode($options) }}, selected, search);"
    class="relative w-full">
    <!-- Select Visible -->
    <div
        x-on:click="
            open = !open;
        "
        class="border rounded-md p-2 cursor-pointer bg-white dark:bg-gray-800">
        <template x-if="selected.length > 0">
            <div class="flex flex-wrap gap-2">
                <template x-for="option in selected" :key="option.id">
                    <span class="bg-slate-100 dark:bg-gray-600 border text-black dark:text-white text-sm pl-2 py-1 rounded-md">
                        <span x-text="option.name"></span>
                        <span class="border-r ml-1"></span>
                        <button
                            x-on:click.stop="
                                selected = selected.filter(o => o.id !== option.id);
                                $wire.{{ $attributes->get('wire:model') }} = selected;
                            "
                            class="mr-1 px-2 rounded-md text-red-500 hover:text-red-700 hover:bg-slate-300 dark-hover:bg-gray-700">
                            &times;
                        </button>
                    </span>
                </template>
            </div>
        </template>

        <span x-show="selected.length === 0" class="text-gray-500">
            {{ $placeholder }}
        </span>
    </div>

    <!-- Opciones -->
    <div
        x-show="open"
        x-on:click.outside="
            open = false;
            search = '';
        "
        class="absolute border bg-white dark:bg-gray-800 rounded-md mt-2 w-full max-h-60 overflow-y-auto z-10">
        <div class="p-2">
            <input
                type="text"
                x-model="search"
                placeholder="{{ __('Search...') }}"
                class="w-full bg-white dark:bg-gray-800 border border-slate-200 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
            />
        </div>
        <template x-for="option in loadOptions({{ json_encode($options) }}, selected, search)" :key="option.id">
            <div
                x-on:click="
                    selected.push(option);
                    search = '';
                    $wire.{{ $attributes->get('wire:model') }} = selected;
                "
                class="py-2 px-4 hover:bg-slate-400 hover:text-white cursor-pointer">
                <span x-text="option.name"></span>
            </div>
        </template>
    </div>

    <!-- Campo oculto para enviar al formulario -->
    <input type="hidden" {{ $attributes->whereDoesntStartWith('class') }}>
</div>
