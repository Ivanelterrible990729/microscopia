<div>
    <div class="mt-10 px-5">
        <div class="text-center text-lg font-medium">
            {{ __('Summary') }}
        </div>
        <div class="mt-2 text-base text-center text-slate-500">
            {{ __('Please review the information recorded in each of the images and save the changes by clicking on the following link') }}
            <a class="text-blue-500 hover:text-blue-700 underline cursor-pointer" href="#confirm-button">
                "{{ __('Confirm') }}"
            </a>.
        </div>
    </div>

    <form wire:submit="confirmWizard">
        <x-base.dialog.description class="mt10 lg:mt-14 border-t border-slate-200/60 px-4 pt-10 dark:border-darkmode-400 lg:px-10">
            <x-validation-errors class="mb-5"/>

            <x-base.table>
                <x-base.table.thead variant="light">
                    <x-base.table.tr>
                        <x-base.table.th class="text-center whitespace-nowrap">
                            #
                        </x-base.table.th>
                        <x-base.table.th class="text-center whitespace-nowrap uppercase">
                            {{ __('ID') }}
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap uppercase">
                            {{ __('Name') }}
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap uppercase">
                            {{ __('Description') }}
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap uppercase">
                            {{ __('Labels') }}
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($imageForms as $index => $imageForm)
                        <x-base.table.tr>
                            <x-base.table.td class="text-center" for="#">
                                {{ $loop->iteration }}
                            </x-base.table.td>
                            <x-base.table.td class="text-center" for="{{ __('ID') }}">
                                {{ $imageForm['id'] }}
                            </x-base.table.td>
                            <x-base.table.td class="text-center sm:text-start" for="{{ __('Name') }}">
                                {{ $imageForm['name'] }}
                            </x-base.table.td>
                            <x-base.table.td class="text-center max-w-[16rem] truncate hover:whitespace-normal sm:text-start" for="{{ __('Description') }}">
                                {{ $imageForm['description'] }}
                            </x-base.table.td>
                            <x-base.table.td class="text-center sm:text-start" for="{{ __('Labels') }}">
                                <x-image.image-labels :label-ids="$imageForm['labelIds']" />
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>

        </x-base.dialog.description>

        <x-base.dialog.footer class="col-span-12 mt-5 flex items-center justify-center sm:justify-end">
            <x-base.button
                class="w-24"
                variant="secondary"
                type="button"
                wire:click='previous'
            >
                {{ __('Previous') }}
            </x-base.button>

            <x-base.button
                id="confirm-button"
                class="ml-2 w-24 focus:border-green-600 focus:border-2 focus:ring-2 focus:ring-green-300"
                variant="success"
                type="submit"
            >
                {{ __('Confirm') }}
            </x-base.button>
        </x-base.dialog.footer>
    </form>
</div>

