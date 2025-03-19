<x-base.alert
    class="intro-y relative"
    variant="soft-pending"
    dismissible
>
    <x-base.alert.dismiss-button class="absolute right-0 top-0 text-slate-500 font-bold -mr-0.5">
        &times;
    </x-base.alert.dismiss-button>
    <x-base.lucide
        class="absolute right-0 bottom-2 mt-5 h-12 w-12 text-danger/80 mr-2"
        icon="circle-alert"
    />
    <h2 class="text-base font-medium">{{ __('Before training') }}...</h2>

    <ul class="mt-2 mb-8 list-disc pl-5 text-sm leading-relaxed text-justify text-slate-600 dark:text-slate-500">
        <li>
            {{ __('Be sure you have good connection.') }}
        </li>
        <li>
            {{ __('Be conscious this process can take some time.') }}
        </li>
        <li class="font-bold">
            {{ __('Do not close this page during training process.') }}
        </li>
    </ul>
</x-base.alert>
