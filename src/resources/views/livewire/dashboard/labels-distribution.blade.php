<div>
    <div class="intro-y flex h-10 items-center">
        <h2 class="mr-5 truncate text-lg font-medium">{{ __('Images distribution per label') }}</h2>
        <button
            class="ml-auto flex items-center text-primary"
            wire:click='countImages'
        >
            <x-base.lucide
                class="mr-3 h-4 w-4"
                icon="RefreshCcw"
            /> {{ __('Refresh') }}
        </button>
    </div>

    <div class="intro-y box mt-5 p-5" x-data="{}" x-init="$wire.call('countImages')">
        <div class="mt-3 w-full">
            <div class="h-[213px]" wire:loading.remove>
                <x-base.chart
                    id="distribution-chart"
                >
                </x-base.chart>
            </div>

            <div class="w-full mt-5" wire:loading>
                <div class="flex flex-row items-center justify-between">
                    <div class="w-2 h-2"></div>
                    <div class="flex animate-pulse items-center">
                        <div class="relative size-44 rounded-full bg-gray-300">
                            <div class="absolute inset-4 size-38 rounded-full bg-white dark:bg-[#28334E]"></div>
                        </div>
                    </div>
                    <div class="w-2 h-2"></div>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-4 w-52 sm:w-auto">

            <div wire:loading.remove>
                @foreach ($this->labels as $label)
                    <div class="mt-4 flex items-center">
                        <div class="mr-3 h-2 w-2 p-1 lg:p-0.5 rounded-full text-xs" style="background-color: {{ $label['color'] }};"></div>
                        <span class="truncate">{{ $label['name'] }}</span>
                        <span class="ml-auto font-medium"> {{ $totalImages > 0 ? number_format(($label['images_count'] * 100) / $totalImages, 0, '.', ',') : 0 }} %</span>
                    </div>
                @endforeach
            </div>

            <div class="w-full" wire:loading>
                <div class="mt-4 flex animate-pulse items-center justify-between">
                    <div class="bg-gray-300 h-4 w-32"></div>
                    <div class="bg-gray-300 h-4 w-8"></div>
                </div>
                <div class="mt-4 flex animate-pulse items-center justify-between">
                    <div class="bg-gray-300 h-4 w-28"></div>
                    <div class="bg-gray-300 h-4 w-12"></div>
                </div>
                <div class="mt-4 flex animate-pulse items-center justify-between">
                    <div class="bg-gray-300 h-4 w-36"></div>
                    <div class="bg-gray-300 h-4 w-10"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('show-distribution-chart', ({ chartColors, labels, data }) => {
            const ctxDist = document.getElementById('distribution-chart');

            if (window.distChart) {
                window.distChart.destroy();
            }

            window.distChart = new Chart(ctxDist, {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: data,
                            backgroundColor: chartColors,
                            hoverBackgroundColor: chartColors,
                            borderWidth: 2,
                            borderColor: () =>
                                $("html").hasClass("dark")
                                    ? getColor("darkmode.700")
                                    : getColor("white"),
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: getColor("slate.500", 0.8),
                            },
                        },
                    },
                    cutout: "80%",
                },
            });
        });
    </script>
@endscript
