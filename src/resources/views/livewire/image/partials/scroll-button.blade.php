<button
    x-show="showButton && selectedImages.length > 0"
    @scroll.window="showButton = (window.pageYOffset > 200)"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="fixed bottom-4 right-4 z-50 p-4 bg-pending border-pending text-white dark:border-pending rounded-full shadow-lg hover:bg-orange-500 focus:ring focus:ring-orange-300 flex flex-row animate-bounce"
    style="display: none;"
    >
    <x-base.lucide
        icon="arrow-up"
        class="mr-2"
    />
    <span class="font-medium text-sm mr-2">{{ __('Selected images') }}:</span>
    <span class="font-medium text-sm mr-2" x-text="selectedImages.length"></span>
</button>
