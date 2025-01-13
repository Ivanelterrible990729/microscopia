@extends('../theme/base')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    <div @class([
        'enigma py-5 px-5 md:py-0 sm:px-8 md:px-0',
        "before:content-[''] before:bg-gradient-to-b before:from-theme-1 before:to-theme-2 dark:before:from-darkmode-800 dark:before:to-darkmode-800 md:before:bg-none md:bg-slate-200 md:dark:bg-darkmode-800 before:fixed before:inset-0 before:z-[-1]",
    ])>
        <x-mobile-menu />
        <x-themes.enigma.top-bar layout="side-menu" />

        <div class="block xl:hidden">
            @yield('breadcrumb')
        </div>

        <div class="flex overflow-hidden">
            <x-side-menu />

            <!-- BEGIN: Content -->
            <div @class([
                'max-w-full md:max-w-none rounded-[30px] md:rounded-none px-4 md:px-[22px] min-w-0 min-h-screen bg-slate-100 flex-1 md:pt-20 pb-10 mt-5 md:mt-1 relative dark:bg-darkmode-700',
                "before:content-[''] before:w-full before:h-px before:block",
            ])>
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <x-themes.enigma.alert />
                    <x-themes.enigma.notification />

                    @yield('subcontent')
                </div>
            </div>
            <!-- END: Content -->
        </div>
    </div>
@endsection

@pushOnce('styles')
    @vite('resources/css/vendors/tippy.css')
    @vite('resources/css/themes/enigma/side-nav.css')
@endPushOnce

@pushOnce('vendors')
    @vite('resources/js/vendors/tippy.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/themes/enigma.js')
    @vite('resources/js/pages/modal.js')
    @vite('resources/js/pages/notification.js')
@endPushOnce
