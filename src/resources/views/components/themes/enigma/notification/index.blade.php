<!-- ------------------------------ Warning Notification ---------------------------------- -->
<x-base.notification
    class="flex"
    id="success-notification"
>
    <x-base.lucide
        id="success-notification-icon"
        class="text-success"
        icon="check-circle"
    />
    <div class="ml-4 mr-4">
        <div
            id="success-notification-title"
            class="text-success font-medium"
        >
            {{ __('Success') }}
        </div>
        <div
            id="success-notification-message"
            class="mt-1 text-slate-500">
        </div>
    </div>
</x-base.notification>

<!-- ------------------------------ Warning Notification ---------------------------------- -->
<x-base.notification
    class="flex"
    id="warning-notification"
>
    <x-base.lucide
        id="warning-notification-icon"
        class="text-warning"
        icon="alert-triangle"
    />
    <div class="ml-4 mr-4">
        <div
            id="warning-notification-title"
            class="text-warning font-medium"
        >
            {{ __('Warning') }}
        </div>
        <div
            id="warning-notification-message"
            class="mt-1 text-slate-500">
        </div>
    </div>
</x-base.notification>

<!-- ------------------------------ Error Notification ------------------------------------ -->
<x-base.notification
    class="flex"
    id="error-notification"
>
    <x-base.lucide
        id="error-notification-icon"
        class="text-danger"
        icon="x-circle"
    />
    <div class="ml-4 mr-4">
        <div
            id="error-notification-title"
            class="text-danger font-medium"
        >
            {{ __('Error') }}
        </div>
        <div
            id="error-notification-message"
            class="mt-1 text-slate-500">
        </div>
    </div>
</x-base.notification>
