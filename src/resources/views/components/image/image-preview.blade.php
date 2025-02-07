@props(['image' => null, 'imageRounded' => true])

<div>
    <x-base.image-zoom
        @class([
            "w-full",
            "rounded-t" => !$imageRounded,
            "rounded-md" => $imageRounded,
        ])
        src="{{ $image->getFirstMediaUrl('*') }}"
        alt="Image"
    />

    <livewire:image.predict-image :image="$image" :key="$image->id" />
</div>
