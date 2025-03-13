<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') . ' - ' . __('Analysis report') }}</title>

        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="px-2 py-8 max-w-2xl mx-auto">
            @foreach ($report as $index => $register)
            <span class="text-green-700">
                {{ now()->translatedFormat('j \d\e F \d\e\l Y') }}
            </span>

            <div class="flex flex-row items-start justify-between mt-5">
                <div>
                    {{ __('Name of the image') }}
                </div>
                <div class="w-1/2">
                    {{ $register['image_name'] }}
                </div>
            </div>

            <div class="flex flex-row items-start justify-between mt-5">
                <div>
                    {{ __('Description') }}
                </div>
                <div class="w-1/2">
                    {{ $register['image_description']  }}
                </div>
            </div>

            <div class="flex flex-row items-start justify-between mt-5">
                <div>
                    {{ __('Illustration') }}
                </div>
                <div class="w-1/2">
                    <img
                        class="h-full w-full image-fit rounded-md mt-2"
                        src="{{ $register['illustration'] }}"
                    />
                </div>
            </div>

            <div class="flex flex-row items-start justify-between mt-5">
                <div>
                    {{ __('Prediction') }}
                </div>
                <div class="w-1/2">
                    {{ $register['prediction']  }}
                </div>
            </div>

            <div class="flex flex-row items-start justify-between mt-5">
                <div>
                    {{ __('Precision') }}
                </div>
                <div class="w-1/2">
                    {{ $register['precision']  }}
                </div>
            </div>

            <div class="flex flex-row items-start justify-between mt-5">
                <div>
                    {{ __('Modelo empleado') }}
                </div>
                <div class="w-1/2">
                    <ul class="list-disc pl-2">
                        <li>

                        </li>
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </body>
</html>
