@extends('../theme/base')

@section('head')
    <title>{{ config('app.name') }} - Verificar correo </title>
@endsection

@section('content')
<div @class([
    'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
    'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400',
    'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform after:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700',
])>
    <!-- BG IMAGE -->
    <img src="{{ Vite::asset('resources/images/bg-image.jpg') }}"
        alt="Imagen de fondo"
        class="absolute inset-0 hidden xl:block w-[57%] -mt-[18%] -mb-[16%] -ml-[13%] transform rounded-[100%] opacity-30 z-10 object-cover"
    />

        <div class="container relative z-10 sm:px-10">
            <div class="block grid-cols-2 gap-x-4 xl:grid">
                <!-- BEGIN: Login Info -->
                <div class="hidden min-h-screen flex-col xl:flex xl:-mb-10">
                    <a class="-intro-x flex items-center pt-5" href="">
                        <div class="flex items-end">
                            <img
                                src="{{ Vite::asset('resources/images/ITRANS.png') }}"
                                alt="ITRANS - Universidad de Guadalajara"
                                class="w-8"
                            />
                            <span class="ml-3 text-lg text-white"> ITRANS</span>
                            <span class="ml-2 text-base text-white">UDG</span>
                        </div>
                    </a>

                    <div class="my-auto w-1/2 flex flex-col items-center">
                        <img
                            src="{{ Vite::asset('resources/images/logo.svg') }}"
                            alt="Microscopía ITRANS"
                            class="-intro-x -mt-16 w-1/4"
                        />
                        <div class="-intro-x mt-10 text-4xl font-medium leading-tight text-white">
                            <b>{{ config('app.name') }}</b>
                        </div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="my-10 flex h-screen py-5 xl:my-0 xl:h-auto xl:py-0">
                    <div class="flex flex-col w-full">

                        <div class="text-right flex justify-end pt-0 xl:pt-4 xl:-mb-10">
                            <x-theme-switcher />
                        </div>

                        <div
                            class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ml-20 xl:w-auto xl:bg-transparent xl:p-0 xl:shadow-none">
                            <div class="intro-x xl:hidden">
                                <div class="flex flex-col items-center">
                                    <x-base.lucide
                                        class="copy-code mr-2 h-16 w-16"
                                        icon="Microscope"
                                    />
                                    <div class="text-center text-slate-400 mt-2">
                                        {{ config('app.name') }}
                                    </div>
                                </div>
                            </div>

                            <div class="intro-x mb-4 text-sm text-gray-600 mt-5">
                                {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </div>

                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                                </div>
                            @endif

                            <div class="mt-4 flex items-center justify-between">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <div>
                                        <x-base.button
                                            type="submit"
                                            class="px-4 py-3 align-top"
                                            variant="primary"
                                        >
                                            {{ __('Reset Password') }}
                                        </x-base.button>
                                    </div>
                                </form>
                            </div>

                            <div class="mt-5">
                                <a
                                    href="{{ route('profile.show') }}"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    {{ __('Edit Profile') }}</a>

                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf

                                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
    </div>
@endsection
