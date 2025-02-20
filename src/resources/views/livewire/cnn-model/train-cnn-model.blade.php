<div>
    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center text-base font-medium">
            <x-base.lucide
                icon="brain-cog"
                class="mr-2"
            />
            {{ __('Train model') }}
        </h2>
    </x-base.dialog.title>

    @if ($onTraining)
        @include('livewire.cnn-model.train-cnn-model.on-training')
    @else
        @include('livewire.cnn-model.train-cnn-model.on-form')
    @endif
</div>

@script
<script>
    $wire.on('next-step', ({ method }) => {
        $wire.call(method);
    })
</script>
@endscript
