@if(Session::has('alert'))
    <x-base.alert
        class="intro-y box col-span-11 mb-6 dark:border-darkmode-600 mt-10"
        variant="{{ Session::get('alert.variant') ?? 'soft-primary' }}"
        dismissible
    >
        <div class="flex items-center">
            @if (session()->has('alert.icon'))
                <span>
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="{{ Session::get('alert.icon') ?? 'check-circle' }}"
                    />
                </span>
            @endif
            <span>
                {!! session('alert.message') !!}
            </span>
            <x-base.alert.dismiss-button class="text-white">
                <x-base.lucide
                    class="h-4 w-4"
                    icon="X"
                />
            </x-base.alert.dismiss-button>
        </div>
    </x-base.alert>
@endif
