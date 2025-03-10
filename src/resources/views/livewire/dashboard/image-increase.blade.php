<div>
    <div class="intro-y block h-10 items-center sm:flex">
        <h2 class="mr-5 truncate text-lg font-medium">{{ __('Monthly increase in images') }}</h2>
    </div>
    <div class="intro-y box mt-12 p-5 sm:mt-5">
        <div class="flex flex-col md:flex-row md:items-center" x-data="{}" x-init="$wire.call('countImages', $wire.dates)">
            <div class="flex">
                <div>
                    <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl">
                        {{ $images['this month'] }} {{ __('images') }}.
                    </div>
                    <div class="mt-0.5 text-slate-500">{{ __('This month') }}</div>
                </div>
                <div
                    class="mx-4 h-12 w-px border border-r border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5">
                </div>
                <div>
                    <div class="text-lg font-medium text-slate-500 xl:text-xl">
                        {{ $images['last month'] }} {{ __('images') }}.
                    </div>
                    <div class="mt-0.5 text-slate-500">{{ __('Last month') }}</div>
                </div>
            </div>

            <div class="mt-3 text-slate-500 sm:ml-auto sm:mt-0">
                <x-base.litepicker
                    id="date-picker"
                    wire:model='dates'
                    :value="$dates"
                    class="datepicker !box pl-10 sm:w-64"
                    type="text"
                />

                <x-base.button
                    variant="dark"
                    class="m-2"
                    x-on:click="
                        dates = document.getElementById('date-picker').value;
                        $wire.call('countImages', dates);
                    "
                >
                    Consultar
                </x-base.button>
            </div>
        </div>
        <div wire:loading.remove>
            <div class="mt-6">
                <div class="h-[275px]">
                    <x-base.chart
                        id="increase-chart"
                    >
                    </x-base.chart>
                </div>
            </div>
        </div>

        <div class="mt-6 w-full" wire:loading>
            <div class="absolute w-full h-[275px] rounded-md border bg-gray-300 p-4 animate-pulse">

            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('show-increase-chart', ({ labels, data }) => {

        const ctxIncr = document.getElementById('increase-chart');

        if (window.incrChart) {
            window.incrChart.destroy();
        }

        window.incrChart = new Chart(ctxIncr, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Imágenes",
                        data: data,
                        borderWidth: 2,
                        borderColor: () => getColor("primary"),
                        backgroundColor: "transparent",
                        pointBorderColor: "transparent",
                        tension: 0.4,
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
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: "12",
                            },
                            color: getColor("slate.500", 0.8),
                        },
                        grid: {
                            display: false,
                        },
                        border: {
                            display: false,
                        },
                    },
                    y: {
                        ticks: {
                            font: {
                                size: "12",
                            },
                            color: getColor("slate.500", 0.8),
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            },
                        },
                        grid: {
                            color: () =>
                                $("html").hasClass("dark")
                                    ? getColor("slate.500", 0.3)
                                    : getColor("slate.300"),
                        },
                        border: {
                            dash: [2, 2],
                            display: false,
                        },
                    },
                },
            },
        });
    });
    </script>
@endscript
