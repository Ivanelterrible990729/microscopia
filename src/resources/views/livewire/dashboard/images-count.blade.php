<div>
    <div class="intro-y flex h-10 items-center">
        <h2 class="mr-5 truncate text-lg font-medium">{{ __('Images count') }}</h2>
        <button
            wire:click='countImages'
            class="ml-auto flex items-center text-primary"
        >
            <x-base.lucide
                class="mr-3 h-4 w-4"
                icon="RefreshCcw"
            /> {{ __('Refresh') }}
        </button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6" x-data="{}" x-init="$wire.call('countImages')">
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div @class([
                'relative zoom-in',
                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
            ])>
                <div class="box p-5">
                    <a href="{{ route('image.index') }}">
                        <div class="flex">
                            <x-base.lucide
                                class="h-[28px] w-[28px] text-primary"
                                icon="images"
                            />
                        </div>

                        <div class="mt-6 text-3xl font-medium leading-8" wire:loading.remove>
                            {{ number_format($images['total'], 0, '.', ',') }}
                        </div>

                        <div class="mt-6 h-8 animate-pulse w-full" wire:loading>
                            <div class="flex space-x-4">
                                <div class="grid grid-cols-12 gap-x-4">
                                    <div class="h-8 bg-slate-400 rounded col-span-3"></div>
                                </div>
                            </div>
                            </div>

                        <div class="mt-1 text-base text-slate-500">
                            {{ __('Total images') }}
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div @class([
                'relative zoom-in',
                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
            ])>
                <div class="box p-5">
                    <a href="{{ route('image.index') }}">
                        <div class="flex">
                            <x-base.lucide
                                class="h-[28px] w-[28px] text-success"
                                icon="scan-eye"
                            />

                            <div class="ml-auto">
                                <x-base.tippy
                                    class="flex cursor-pointer items-center rounded-full bg-secondary py-[3px] pl-2 pr-1 text-xs text-black font-medium"
                                    as="div"
                                    content=""
                                >
                                    {{ $images['labeled'] == 0 ? 0 : number_format(($images['labeled'] * 100) / $images['total'], 0, '.', ',') }}%
                                </x-base.tippy>
                            </div>
                        </div>

                        <div class="mt-6 text-3xl font-medium leading-8" wire:loading.remove>
                            {{ number_format($images['labeled'], 0, '.', ',') }}
                        </div>

                        <div class="mt-6 h-8 animate-pulse w-full" wire:loading>
                            <div class="flex space-x-4">
                                <div class="grid grid-cols-12 gap-x-4">
                                    <div class="h-8 bg-slate-400 rounded col-span-3"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-1 text-base text-slate-500">
                            {{ __('Classified images') }}
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div @class([
                'relative zoom-in',
                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
            ])>
                <div class="box p-5">
                    <a href="{{ route('image.index') . '?table-filters[etiquetas][0]=unlabeled' }}">
                        <div class="flex">
                            <x-base.lucide
                                class="h-[28px] w-[28px] text-pending"
                                icon="scan-search"
                            />

                            <div class="ml-auto">
                                <x-base.tippy
                                    class="flex cursor-pointer items-center rounded-full bg-secondary py-[3px] pl-2 pr-1 text-xs text-black font-medium"
                                    as="div"
                                    content=""
                                >
                                    {{ $images['unlabeled'] == 0 ? 0 : number_format(($images['unlabeled'] * 100) / $images['total'], 0, '.', ',') }}%
                                </x-base.tippy>
                            </div>
                        </div>

                        <div class="mt-6 text-3xl font-medium leading-8" wire:loading.remove>
                            {{ number_format($images['unlabeled'], 0, '.', ',') }}
                        </div>

                        <div class="mt-6 h-8 animate-pulse w-full" wire:loading>
                            <div class="flex space-x-4">
                                <div class="grid grid-cols-12 gap-x-4">
                                    <div class="h-8 bg-slate-400 rounded col-span-3"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-1 text-base text-slate-500">
                            {{ __('Images to be classified') }}
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div @class([
                'relative zoom-in',
                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
            ])>
                <div class="box p-5">
                    <a href="{{ route('image.index') . '?table-filters[imágenes]=trashed' }}">
                        <div class="flex">
                            <x-base.lucide
                                class="h-[28px] w-[28px] text-danger"
                                icon="trash-2"
                            />
                        </div>

                        <div class="mt-6 text-3xl font-medium leading-8" wire:loading.remove>
                            {{ number_format($images['deleted'], 0, '.', ',') }}
                        </div>

                        <div class="mt-6 h-8 animate-pulse w-full" wire:loading>
                            <div class="flex space-x-4">
                                <div class="grid grid-cols-12 gap-x-4">
                                    <div class="h-8 bg-slate-400 rounded col-span-3"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-1 text-base text-slate-500">
                            {{ __('Deleted images') }}
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
