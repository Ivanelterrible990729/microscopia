<div>
    @php
        use App\Models\CnnModel;
    @endphp

    <div class="pt-8 px-5">
        <x-base.form-label for="state.roles">
            <div class="text-left">
                <div class="font-medium">{{ __('CNN Models') }}:</div>
            </div>
        </x-base.form-label>

        @forelse ($models as $model)
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6 mb-4">
            <div class="flex flex-col">
                <span>{{ $model->name }}</span>
            </div>

            <x-base.button
                title="{{ __('Analyze') }}"
                wire:click='predict({{ $model }})'
                variant="soft-dark"
                size="md"
                wire:loading.attr="disabled"
            >
                <x-base.lucide
                    icon="scan-eye"
                    class="mr-2"
                />
                {{ __('Analyze') }}
            </x-base.button>
        </div>

        @if (isset($predictions[$model->id]) && $predictions[$model->id] != null)
            <div class="mt-2 rounded font-medium text-center px-3 py-2" style="border-width: 3px; border-color: {{ $predictions[$model->id]['color'] }}; color: {{ $predictions[$model->id]['color'] }};" wire:loading.remove>
                {{ $predictions[$model->id]['percentage'] }}% {{ $predictions[$model->id]['name'] }}
            </div>
        @elseif (isset($predictions[$model->id]) && is_null($predictions[$model->id]))
            <div class="mt-2 rounded font-medium text-center px-3 py-2 text-slate-400 dark:text-slate-300 border border-slate-400 dark:border-slate-300"  style="border-width: 3px;" wire:loading.remove>
                {{ __('No prediction') }}
            </div>
        @endif

        <div class="animate-pulse border border-slate-400 shadow rounded px-3 py-2 w-full" style="border-width: 3px;" wire:loading>
            <div class="flex space-x-4">
                <div class="flex-1 space-y-6 py-2">
                    <div class="grid grid-cols-12 gap-x-4">
                        <div class="col-span-2"></div>
                        <div class="h-2 bg-slate-400 rounded col-span-2"></div>
                        <div class="h-2 bg-slate-400 rounded col-span-6"></div>
                        <div class="col-span-2"></div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-dark border-dark bg-opacity-20 border-opacity-5 text-dark dark:bg-darkmode-800/30 dark:border-darkmode-800/60 dark:text-slate-300 text-center">
            <div class="flex flex-col p-5">
                <span class="font-medium">No hay modelos</span>

                <img
                    class="h-24 lg:h-auto mb-2"
                    src="{{ Vite::asset('resources/images/error-illustration.svg') }}"
                    alt="ITRANS - Error Illustration"
                />

                @can('create', CnnModel::class)
                    <x-base.button
                        as="a"
                        href="{{ route('cnn-model.index') }}"
                        variant="primary"
                    >
                        @include('icons.plus')
                        Crear modelo
                    </x-base.button>
                @endcan
            </div>
        </div>
    @endforelse
    </div>

    <div class="border-t mt-5 p-5">
        {{ $models->links('livewire.image.predict-image.pagination') }}
    </div>
</div>
