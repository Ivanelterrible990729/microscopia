@props(['image' => null, 'store' => false, 'redirectToShow' => false])

<x-base.dialog id="modal-add-labels-image" size="xl" static-backdrop>
    <x-base.dialog.panel>
        <livewire:image.add-labels-image :image="$image" :store="$store" :redirect-to-show="$redirectToShow" />
    </x-base.dialog.panel>
</x-base.dialog>
