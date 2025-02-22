<div>
    <a
        class="absolute top-0 left-0 right-auto mt-4 -ml-10 sm:-ml-12"
        data-tw-dismiss="modal"
        href="#"
    >
        <x-base.lucide
            class="w-8 h-8 text-slate-400"
            icon="X"
        />
    </a>

    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center text-base font-medium">
            <x-base.lucide
                icon="activity"
                class="mr-2"
            />
            {{ __('Activity detail') }}
        </h2>
    </x-base.dialog.title>

    <x-base.dialog.description class="mr-2">
        <div class="text-center text-base font-bold w-full mb-2">
            {{ __('Details') }}
        </div>

        <div class="grid grid-cols-12 gap-6 mr-2">
            <div class="col-span-12 lg:col-span-6">
                <span>
                    {{ __('Causer') }}
                </span>
                <div class="border rounded p-2 bg-gray-100 dark:bg-gray-800 mt-2">
                    <x-activity.causer-link :causer-id="$activity?->causer_id" link />
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <span>
                    {{ __('Subject') }}
                </span>
                <div class="border rounded p-2 bg-gray-100 dark:bg-gray-800 mt-2">
                    <x-activity.subject-link :subject-id="$activity?->subject_id" :subject-type="$activity?->subject_type" link />
                </div>
            </div>

            <div class="col-span-12">
                <span>
                    {{ __('Module') }}
                </span>
                <div class="border rounded p-2 bg-gray-100 dark:bg-gray-800 mt-2">
                    {{ $activity?->log_name }}
                </div>
            </div>

            <div class="col-span-12">
                <span>
                    {{ __('Description') }}
                </span>
                <div class="border rounded p-2 bg-gray-100 dark:bg-gray-800 mt-2">
                    {{ $activity?->description }}
                </div>
            </div>

            <div class="col-span-12">
                <span>
                    {{ __('Properties') }}
                </span>
                <div class="border rounded p-2 bg-gray-100 dark:bg-gray-800 mt-2">
                    <pre class="">{{ json_encode(json_decode($activity?->properties), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </div>
        </div>
    </x-base.dialog.description>
</div>
