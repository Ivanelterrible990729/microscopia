<x-base.dialog id="modal-delete-cnn-model" static-backdrop>
    <x-base.dialog.panel>
        <div class="p-5 text-center">
            <x-base.lucide
                class="mx-auto mt-3 h-16 w-16 text-danger"
                icon="trash-2"
            />
            <div class="mt-5 text-2xl">{{ __('Delete model') }}</div>
            <div class="mt-5 text-3xl">{{ $cnnModel->name }}</div>
            <div class="mt-5 text-slate-500">
                {{ __('Are you sure to delete the selected model?') }}
            </div>
        </div>

        <form method="POST" action="{{ route('cnn-model.destroy', $cnnModel) }}">
            @method('DELETE')
            @csrf

            <div class="px-5 pb-8 text-center">
                <x-base.button
                    class="mr-1 w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    {{ __('Cancel') }}
                </x-base.button>

                <x-base.button
                    class="w-24"
                    type="submit"
                    variant="danger"
                >
                    {{ __('Delete') }}
                </x-base.button>
            </div>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

