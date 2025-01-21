@props(['image' => null, 'imageRounded' => true])

<x-base.image-zoom
    @class([
        "w-full",
        "rounded-t" => !$imageRounded,
        "rounded-md" => $imageRounded,
    ])
    src="{{ $image->getFirstMediaUrl(App\Enums\Media\MediaEnum::Images->value) }}"
    alt="Image"
/>

<div class="p-5">
    <x-base.form-label for="state.roles">
        <div class="text-left">
            <div class="font-medium">{{ __('Predicciones') }}:</div>
        </div>
    </x-base.form-label>

    <div class="box p-5">
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
                        class="mr-0 lg:mr-2 h-4 w-4"
                        icon="tag"
                    />
                    <span class="hidden lg:block">
                        {{__('Add label') }}
                    </span>
                </button>
            </div>
        </div>
        <div class="mt-2 rounded font-medium text-center px-2 py-1" style="border-width: 2px; border-color: #F59E0B; color: #F59E0B">
            93% MUSCULO
        </div>
    </div>
</div>
