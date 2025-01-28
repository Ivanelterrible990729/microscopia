<div>
    <div class="p-5">
        <x-base.form-label for="state.roles">
            <div class="text-left">
                <div class="font-medium">{{ __('Predictions') }}:</div>
            </div>
        </x-base.form-label>

        <div class="box p-5">
            @forelse ($models as $model)
                <div class="flex flex-row items-center justify-between mb-5">
                    <div>
                        {{ __('Model') }}: <span class="font-medium">{{ $model->name }}</span>
                    </div>

                    <button
                        class="flex items-center text-slate-600 dark:text-slate-300"
                        title="{{ __('Refresh') }}"
                        wire:click='predict({{ $model }})'
                    >
                        <x-base.lucide
                            icon="refresh-ccw"
                        />
                    </button>
                </div>

                @if (isset($prediction))
                    <div class="mt-2 rounded font-medium text-center px-3 py-2" style="border-width: 3px; border-color: {{ $prediction['color'] }}; color: {{ $prediction['color'] }};" wire:loading.remove>
                        {{ $prediction['percentage'] }}% {{ $prediction['name'] }}
                    </div>
                @else
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

                        <x-base.button
                            variant="primary"
                        >
                            @include('icons.plus')
                            Crear modelo
                        </x-base.button>
                    </div>
                </div>
            @endforelse
        </div>

        <div x-data="{}">
            <div x-on:updated-page.window="$wire.predict({{ $model->id }})"></div>
        </div>

        <div class="mt-5">
            {{ $models->links('livewire.image.predict-image.pagination') }}
        </div>
    </div>
</div>

@script
<script>
    $wire.predict({{ $model->id }});
</script>
@endscript
