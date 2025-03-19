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
        @foreach ($report as $index => $register)
            <div class="px-2 py-8 max-w-2xl h-screen mx-auto relative">
                <header class="flex flex-row items-center mb-10">
                    <img
                        class="h-8 w-8 image-fit mr-2 opacity-30"
                        src="{{ Vite::asset('resources/images/ITRANS.png') }}"
                    />

                    <h2 class="text-2xl font-black uppercase text-slate-500 opacity-30">
                        {{ __('Analysis report') }}
                    </h2>
                </header>

                <div class="text-green-700 text-sm mb-10">
                    {{ now()->translatedFormat('j \d\e F \d\e\l Y') }}
                </div>

                <div class="flex flex-row items-start justify-between mt-8">
                    <div class="font-bold">
                        {{ __('Name of the image') }}
                    </div>
                    <div class="w-1/2 text-justify">
                        {{ $register['image_name'] }}
                    </div>
                </div>

                <div class="flex flex-row items-start justify-between mt-8">
                    <div class="font-bold">
                        {{ __('Description') }}
                    </div>
                    <div class="w-1/2 text-justify">
                        {{ $register['image_description']  }}
                    </div>
                </div>

                <div class="flex flex-row items-start justify-between mt-8">
                    <div class="font-bold">
                        {{ __('Illustration') }}
                    </div>
                    <div class="w-1/2 text-justify">
                        <img
                            class="h-full w-full image-fit"
                            src="{{ $register['illustration'] }}"
                        />
                    </div>
                </div>

                <div class="flex flex-row items-start justify-between mt-8">
                    <div class="font-bold">
                        {{ __('Prediction') }}
                    </div>
                    <div class="w-1/2 text-justify">
                        {{ $register['prediction']  }}
                    </div>
                </div>

                <div class="flex flex-row items-start justify-between mt-8">
                    <div class="font-bold">
                        {{ __("Prediction's presicion") }}
                    </div>
                    <div class="w-1/2 text-justify">
                        {{ $register['precision']  }}%
                    </div>
                </div>

                <div class="flex flex-row items-start justify-between mt-8">
                    <div class="font-bold">
                        {{ __('Model used') }}
                    </div>
                    <div class="w-1/2 text-justify">
                        <span>
                            {{ $cnnModel->name }}
                        </span>
                        <ul class="list-disc pl-4 mt-1">
                            <li>
                                <span>
                                    {{ __('Training accuracy') }}:
                                </span>
                                <span>
                                    {{ $cnnModel->accuracy }}
                                </span>
                            </li>
                            <li>
                                <span>
                                    {{ __('Training loss') }}:
                                </span>
                                <span>
                                    {{ $cnnModel->loss }}
                                </span>
                            </li>
                            <li>
                                <span>
                                    {{ __('Validation accuracy') }}:
                                </span>
                                <span>
                                    {{ $cnnModel->val_accuracy }}
                                </span>
                            </li>
                            <li>
                                <span>
                                    {{ __('Validation loss') }}:
                                </span>
                                <span>
                                    {{ $cnnModel->val_loss }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <footer class="absolute bottom-10 left-0 right-0 w-full text-center">
                    {{ __('Page') }}
                    <b>
                        {{ $loop->iteration }}
                    </b>
                    {{ __('of') }}
                    <b>
                        {{ count($report) }}
                    </b>
                </footer>
            </div>
            @pageBreak
        @endforeach
    </body>
</html>
