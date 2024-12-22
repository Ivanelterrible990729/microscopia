@extends('../theme/base')

@section('head')
    <title>{{ config('app.name') }} - Iniciar sesión </title>
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
                            <x-dark-mode-switcher />
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

                            @session('status')
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ $value }}
                                </div>
                            @endsession

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <h2 class="intro-x text-center text-2xl xl:text-3xl font-bold xl:text-left mt-5 xl:mt-0">
                                    Inicio de sesión
                                </h2>

                                <div class="intro-x mt-8">
                                    <x-base.form-input
                                        id="email"
                                        type="email"
                                        name="email"
                                        :value="old('email')"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        class="intro-x block min-w-full px-4 py-3 xl:min-w-[450px]"
                                        placeholder="{{ __('Email') }}"
                                    />
                                    <x-base.form-input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[450px]"
                                        placeholder="{{ __('Password') }}"
                                    />
                                </div>

                                <div class="intro-x mt-4 flex text-xs text-slate-600 dark:text-slate-500 sm:text-sm">
                                    <div class="mr-auto flex items-center">
                                        <x-base.form-check.input
                                            class="mr-2 border"
                                            id="remember-me"
                                            name="remember"
                                            type="checkbox"
                                        />
                                        <label class="cursor-pointer select-none" for="remember-me">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                </div>

                                <div class="intro-x mt-5 text-center xl:mt-8 xl:text-left">
                                    <x-base.button
                                        class="w-full px-4 py-3 align-top xl:mr-3"
                                        variant="primary"
                                    >
                                        {{ __('Log in') }}
                                    </x-base.button>
                                </div>
                            </form>

                            <x-validation-errors class="mt-8 intro-x" />
                        </div>
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
    </div>
@endsection
