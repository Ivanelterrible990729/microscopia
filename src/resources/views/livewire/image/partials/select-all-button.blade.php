<div class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
    <x-base.form-check.input
        id="selectAll"
        class="border"
        type="checkbox"
        class="mr-2"
        x-model="selectAll"
        x-on:change="selectedImages = selectAll ? {{ json_encode($this->getRows->pluck('id')->toArray()) }} : [];"
    />
    <label for="selectAll" class="inline-block"> {{ __('Select all') }} </label>
</div>
