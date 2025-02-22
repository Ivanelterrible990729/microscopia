@props(['layout' => 'side-menu'])

<!-- BEGIN: Top Bar -->
<div @class([
    'h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-12 md:mt-0 -mx-5 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700',
    "before:content-[''] before:absolute before:h-[65px] before:inset-0 before:top-0 before:mx-7 before:bg-primary/30 before:mt-3 before:rounded-xl before:hidden before:md:block before:dark:bg-darkmode-600/30",
    "after:content-[''] after:absolute after:inset-0 after:h-[65px] after:mx-3 after:bg-primary after:mt-5 after:rounded-xl after:shadow-md after:hidden after:md:block after:dark:bg-darkmode-600",
])>
    <div class="flex h-full items-center">

        <!-- BEGIN: Logo -->
        <a href="" class="-intro-x hidden md:flex items-center xl:w-[180px]">
            <img
                class="w-6"
                src="{{ Vite::asset('resources/images/logo.svg') }}"
                alt="Microscopía ITRANS"
            />
            <span class="ml-3 text-white hidden xl:block">
                {{ config('app.name') }}
            </span>
        </a>
        <!-- END: Logo -->

        <!-- BEGIN: Breadcrumb -->
        <div class="hidden md:block">
            @yield('breadcrumb')
        </div>
        <!-- END: Breadcrumb -->

        <div class="ml-auto flex items-center">
            <!-- BEGIN: LogViewer -->
            @can ('viewLogViewer')
                <div class="mr-4 sm:mr-6">
                    <div class="intro-x">
                        <a href="{{ route('log-viewer.index') }}" class="text-white/70">
                            <x-base.lucide
                                class="h-5 w-5 dark:text-slate-500"
                                icon="Bug"
                            />
                        </a>
                    </div>
                </div>
            @endcan
            <!-- END: LogViewer -->

            <!-- BEGIN: Personifications -->
            @if (Session::has('personified_by'))
                <x-base.popover class="mr-4 sm:mr-6">
                    <x-base.popover.button
                        class="intro-x relative block text-white/70 outline-none before:absolute before:animate-ping before:right-0 before:top-[-2px] before:h-[8px] before:w-[8px] before:rounded-full before:bg-danger before:content-['']"
                    >
                        <x-base.lucide
                            class="h-5 w-5 dark:text-slate-500"
                            icon="log-out"
                        />
                    </x-base.popover.button>
                    <x-base.popover.panel class="mt-2 w-[280px] p-5 sm:w-[350px]">
                        <div class="mb-5 font-medium">
                            {{ __('Personified by') }}:
                            <span class="mr-1 rounded-full border px-2 py-1 text-slate-600 dark:border-darkmode-100/40 dark:text-slate-300 ml-2">
                                {{ __('User') . ' ' . Session::get('personified_by') }}
                            </span>
                        </div>
                        <div class="text-right text-sm">
                            <x-base.button
                                as="a"
                                href="{{ route('user.personification.stop') }}"
                                variant="danger"
                            >
                                <x-base.lucide
                                    class="h-4 w-4 mr-2"
                                    icon="circle-stop"
                                />
                                {{ __('Stop personification') }}
                            </x-base.button>
                        </div>
                    </x-base.popover.panel>
                </x-base.popover>
            @endif
            <!-- BEGIN: Personifications -->

            <!-- BEGIN: Darkmode Switcher -->
            <div class="z-10 mr-4 sm:mr-6">
                <x-dark-mode-switcher />
            </div>
            <!-- END: Darkmode Switcher -->
        </div>

        <!-- BEGIN: Account Menu -->
        <x-base.menu>
            <x-base.menu.button class="intro-x zoom-in flex flex-row items-center">
                <div class="hidden sm:flex flex-col text-right mr-3">
                    <div class="font-medium text-white">
                        {{ Auth::user()->full_name }}
                    </div>
                    <div class="mt-0.5 text-xs text-white/70 dark:text-slate-500">
                        {{ Auth::user()->cargo }}
                    </div>
                </div>

                <div class="image-fit zoom-in block h-8 w-8 scale-110 overflow-hidden rounded-full shadow-lg">
                    <img
                        src="{{ Auth::user()->profile_photo_url }}"
                        alt="User's photo"
                    />
                </div>
            </x-base.menu.button>

            <x-base.menu.items
                class="relative mt-px w-56 bg-theme-1/80 text-white before:absolute before:inset-0 before:z-[-1] before:block before:rounded-md before:bg-black"
            >
                <x-base.menu.header class="font-normal">
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="mt-0.5 text-xs text-white/70 dark:text-slate-500">
                        {{ Auth::user()->cargo }}
                    </div>
                    <div class="mt-0.5 text-xs text-white/70 dark:text-slate-500">
                        {{ Auth::user()->email }}
                    </div>
                </x-base.menu.header>

                <x-base.menu.divider class="bg-white/[0.08]" />

                <x-base.menu.item class="hover:bg-white/5" href="{{ route('profile.show') }}">
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="User"
                    /> {{ __('Edit Profile') }}
                </x-base.menu.item>

                <x-base.menu.divider class="bg-white/[0.08]" />

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <x-base.menu.item as="button" type="submit" class="w-full hover:bg-white/5">
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="ToggleRight"
                        /> {{ __('Log Out') }}
                    </x-base.menu.item>
                </form>
            </x-base.menu.items>
        </x-base.menu>
        <!-- END: Account Menu -->
    </div>
</div>
<!-- END: Top Bar -->

@pushOnce('scripts')
    @vite('resources/js/components/themes/enigma/top-bar.js')
@endPushOnce
