<div>
    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center text-base font-medium">
            <x-base.lucide
                icon="file-box"
                class="mr-2"
            />
            {{ __('Analysis report') }}
        </h2>
    </x-base.dialog.title>

    <x-base.dialog.description>
        <x-validation-errors class="mb-5" />

        <x-base.form-inline
            class="my-5 flex-col items-start pt-5 px-2 first:mt-0 first:pt-0 xl:flex-row"
            formInline
        >
            <x-base.form-label for="modelPath" class="xl:!mr-10 xl:w-64">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium">{{ __('Available models') }}</div>
                    </div>
                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                        {{ __('Choose the model to use in the image report.') }}
                    </div>
                </div>
            </x-base.form-label>
            <div class="mt-3 w-full flex-1 xl:mt-0">
                <x-base.form-select
                    id="modelPath"
                    name="modelPath"
                    wire:model='modelPath'
                >
                    @foreach ($this->availableModels as $value => $modelName)
                        <option value="{{ $value }}">
                            {{ $modelName }}
                        </option>
                    @endforeach
                </x-base.form-select>
            </div>
        </x-base.form-inline>

        @if (count($imageIds) > 1)
            <div class="mt-3 px-2 text-xs font-mediumm leading-relaxed text-slate-500">
                <b>
                    {{ count($imageIds) }}
                </b>
                {{ __('images where selected to perform this action.') }}
            </div>
        @endif

        <a
            id="generatePDF"
            target="_blank"
            href="{{ route('image.pdf-report', ['imageIds' => $imageIds, 'predictions' => $predictions, 'modelId' => $modelId]) }}"
            class="hidden">
                {{ __('Generate PDF') }}
        </a>
    </x-base.dialog.description>

    <x-base.dialog.footer>
        <x-base.button
            class="mr-2"
            data-tw-dismiss="modal"
            type="button"
            variant="secondary"
            wire:loading.remove
        >
            <x-base.lucide
                icon="undo-2"
                class="mr-2"
            />
            {{ __('Cancel') }}
        </x-base.button>
        <x-base.button
            type="button"
            variant="success"
            wire:click='reportImages'
            wire:loading.attr='disabled'
        >
            <div wire:loading>
                <div class="inline-flex items-center justify-center">
                    <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600 mr-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                    <span>{{ __('Creating report') }}</span>
                </div>
            </div>
            <div class="inline-flex items-center justify-center" wire:loading.remove>
                <x-base.lucide
                    icon="file-box"
                    class="mr-2"
                />
                {{ __('Create report') }}
            </div>
        </x-base.button>
    </x-base.dialog.footer>
</div>

@script
    <script>
        $wire.on('images-reported', () => {
            var redirectButton = document.getElementById('generatePDF');
            setTimeout(() => {
                redirectButton.click();
            }, 1000);
        });
    </script>
@endscript
