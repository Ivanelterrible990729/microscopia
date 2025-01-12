<div class="box p-2 mt-5">
    <div class="md:p-0 sm:flex justify-between items-center space-y-4 sm:space-y-0">
        <div>
            @if ($this->paginationIsEnabled && $this->isPaginationMethod('standard') && $this->getRows->lastPage() > 1 && $this->showPaginationDetails)
                <p class="paged-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                        <span>{{ __($this->getLocalisationPath.'Showing') }}</span>
                        <span class="font-medium">{{ $this->getRows->firstItem() }}</span>
                        <span>{{ __($this->getLocalisationPath.'to') }}</span>
                        <span class="font-medium">{{ $this->getRows->lastItem() }}</span>
                        <span>{{ __($this->getLocalisationPath.'of') }}</span>
                        <span class="font-medium"><span x-text="paginationTotalItemCount"></span></span>
                        <span>{{ __($this->getLocalisationPath.'results') }}</span>
                </p>
            @elseif ($this->paginationIsEnabled && $this->isPaginationMethod('simple') && $this->showPaginationDetails)
                <p class="paged-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                    <span>{{ __($this->getLocalisationPath.'Showing') }}</span>
                    <span class="font-medium">{{ $this->getRows->firstItem() }}</span>
                    <span>{{ __($this->getLocalisationPath.'to') }}</span>
                    <span class="font-medium">{{ $this->getRows->lastItem() }}</span>
                </p>
            @elseif ($this->paginationIsEnabled && $this->isPaginationMethod('cursor'))
            @else
                @if($this->showPaginationDetails)
                    <p class="total-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                        <span>{{ __($this->getLocalisationPath.'Showing') }}</span>
                        <span class="font-medium">{{ $this->getRows->count() }}</span>
                        <span>{{ __($this->getLocalisationPath.'results') }}</span>
                    </p>
                @endif
            @endif
        </div>

        @if ($this->paginationIsEnabled)
            {{ $this->getRows->links('livewire-tables::specific.tailwind.'.(!$this->isPaginationMethod('standard') ? 'simple-' : '').'pagination') }}
        @endif
    </div>
</div>
