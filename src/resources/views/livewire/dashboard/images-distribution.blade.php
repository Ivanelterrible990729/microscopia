<div>
    <div class="intro-y flex h-10 items-center">
        <h2 class="mr-5 truncate text-lg font-medium">{{ __('Images distribution') }}</h2>
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
    <div class="intro-y box mt-5 p-5">
        <div class="mt-3">
            <div class="h-[213px]">
                <x-base.chart
                    id="distribution-chart"
                    {{-- class="donut-chart" --}}
                >
                </x-base.chart>
            </div>
        </div>
        <div class="mx-auto mt-8 w-52 sm:w-auto">
            <div class="flex items-center">
                <div class="mr-3 h-2 w-2 rounded-full bg-primary"></div>
                <span class="truncate">17 - 30 Years old</span>
                <span class="ml-auto font-medium">62%</span>
            </div>
            <div class="mt-4 flex items-center">
                <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                <span class="truncate">31 - 50 Years old</span>
                <span class="ml-auto font-medium">33%</span>
            </div>
            <div class="mt-4 flex items-center">
                <div class="mr-3 h-2 w-2 rounded-full bg-warning"></div>
                <span class="truncate">&gt;= 50 Years old</span>
                <span class="ml-auto font-medium">10%</span>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('show-distribution-chart', ({ chartColors, labels, data }) => {
            const ctxDist = document.getElementById('distribution-chart');
            const distChart = new Chart(ctxDist, {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: data,
                            backgroundColor: chartColors,
                            hoverBackgroundColor: chartColors,
                            borderWidth: 5,
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

            helper.watchClassNameChanges($("html")[0], (currentClassName) => {
                distChart.update();
            });
        });
    </script>
@endscript
