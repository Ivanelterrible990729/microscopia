<label for="selectAll" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm text-gray-700 hover:bg-gray-50
    focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 cursor-pointer">
    <x-base.form-check.input
        id="selectAll"
        class="border"
        type="checkbox"
        class="border-2 bg-slate-50 mr-2"
        x-model="selectAll"
        x-on:change="selectedImages = selectAll ? {{ json_encode($this->getRows->pluck('id')->toArray()) }} : [];"
    />
    <span class="inline-block text-xs select-none mt-0.5"> {{ __('Select all') }} </span>
</label>
