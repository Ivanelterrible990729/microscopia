<button class="text-blue-700 hover:text-blue-500 dark:text-blue-500 dark:hover:text-blue-700 underline" x-on:click="$dispatch('show-activity-details', { activityId: {{ $value }} })">
    {{ $value }}
</button>
