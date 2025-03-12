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
        let trainingInterval = null;

        $wire.on('next-step', ({ method }) => {
            $wire.call(method);
            console.log(method);
        });

        $wire.on('check-process', ({ method, milliseconds }) => {
            if (!trainingInterval) {
                trainingInterval = setInterval(() => {
                    console.log('check ', method);
                    $wire.call('checkStatusProcess', method).then(status => {
                        if (status === 'error' || status === 'successfull') {
                            clearInterval(trainingInterval);
                            trainingInterval = null;
                        }
                    });
                }, milliseconds);
            }
        });
    </script>
@endscript
