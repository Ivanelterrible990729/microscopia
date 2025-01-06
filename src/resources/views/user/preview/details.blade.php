<div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
    <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
        <div class="image-fit h-20 w-20 flex-none sm:h-24 sm:w-24 lg:h-32 lg:w-32">
            <img
                class="rounded-full"
                src="{{ $user->profile_photo_url }}"
                alt="{{ $user->prefijo . ' ' . $user->name }} picture"
            />
        </div>
        <div class="ml-5">
            <div class="w-24 truncate text-lg font-medium sm:w-40 sm:whitespace-normal">
                {{ $user->prefijo . ' ' . $user->name }}
            </div>
            <div class="text-slate-500">
                {{ $user->cargo }}
            </div>
        </div>
    </div>
    <div
        class="mt-6 flex-1 border-l border-r border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-t-0 lg:pt-0">
        <div class="text-center font-medium lg:mt-3 lg:text-left">
            {{ __('Details') }}
        </div>
        <div class="mt-4 flex flex-col items-center justify-center lg:items-start">
            <div class="flex items-center truncate sm:whitespace-normal">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="Mail"
                />
                <span class="font-medium mr-2">
                    {{ __('Email') }}:
                </span>
                {{ $user->email}}
            </div>
            <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="timer"
                />
                <span class="font-medium mr-2">
                    {{ __('Created at') }}:
                </span>
                {{ $user->created_at }}
            </div>
            <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="timer-reset"
                />
                <span class="font-medium mr-2">
                    {{ __('Updated at') }}:
                </span>
                {{ $user->updated_at }}
            </div>
        </div>
    </div>
    <div
        class="mt-6 flex-1 border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-0 lg:pt-0">
        <div class="text-center font-medium lg:mt-3 lg:text-left">
            {{ __('Actions') }}
        </div>
        <div class="mt-2 flex items-center justify-center lg:justify-start">
            @can('personify', $user)
                <x-base.button
                        as="a"
                        href="{{ route('user.personification.start', $user) }}"
                        class="align-top"
                        variant="warning"
                    >
                    <x-base.lucide
                        icon="user"
                        class="mr-2"
                    />
                    {{ __('Personify') }}
                </x-base.button>
            @endcan
        </div>
        <div class="mt-2 flex items-center justify-center lg:justify-start">
            <x-base.button
                onclick="dispatchModal('modal-delete-role', 'show')"
                class="align-top"
                variant="danger"
            >
                <x-base.lucide
                    icon="trash-2"
                    class="mr-2"
                />
                {{ __('Delete') }}
            </x-base.button>
        </div>
    </div>
</div>
