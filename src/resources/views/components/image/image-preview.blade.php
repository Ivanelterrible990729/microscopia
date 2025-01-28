@props(['image' => null, 'imageRounded' => true])

<div>
    <x-base.image-zoom
        @class([
            "w-full",
            "rounded-t" => !$imageRounded,
            "rounded-md" => $imageRounded,
        ])
        src="{{ $image->getFirstMediaUrl(App\Enums\Media\MediaEnum::Images->value) }}"
        alt="Image"
    />

    <livewire:image.predict-image :key="$image->id" />
</div>
