@extends('../theme/base')

@section('head')
<title>{{ config('app.name') }} - {{ __('Unauthorized') }} </title>
@endsection

@section('content')
    <div class="py-2 bg-gradient-to-b from-theme-1 to-theme-2 dark:from-darkmode-800 dark:to-darkmode-800">
        <div class="container">
            <!-- BEGIN: Error Page -->
            <div class="flex flex-col items-center justify-center h-screen text-center error-page lg:flex-row lg:text-left">
                <div class="-intro-x lg:mr-20">
                    <img
                        class="h-48 w-[450px] lg:h-auto"
                        src="{{ Vite::asset('resources/images/error-illustration.svg') }}"
                        alt="ITRANS - Error Illustration"
                    />
                </div>
                <div class="mt-10 text-white lg:mt-0">
                    <div class="font-medium intro-x text-8xl">401</div>
                    <div class="mt-5 text-xl font-medium intro-x lg:text-3xl">
                        {{ __('Unauthorized') }}
                    </div>
                    <div class="mt-3 text-base intro-x">
                        {{ __($exception->getMessage() ?: 'Unauthorized') }}
                    </div>
                    <x-base.button
                        as="a"
                        href="{{ url()->previous() }}"
                        class="px-4 py-3 mt-10 text-white border-white intro-x dark:border-darkmode-400 dark:text-slate-200"
                    >
                        {{ __('Return') }}
                    </x-base.button>
                </div>
            </div>
            <!-- END: Error Page -->
        </div>
    </div>
@endsection

