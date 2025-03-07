@extends('../theme/base')

@section('head')
    <title>{{ config('app.name') }}</title>
@endsection

@section('content')
    <nav id="header" class="fixed w-full z-30 top-0 text-white bg-[#064E3B]">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
            <div class="-intro-x pl-4 py-2 flex items-center text-white">
                <a href="/" class="flex items-end">
                    <img
                        src="{{ Vite::asset('resources/images/ITRANS.png') }}"
                        alt="ITRANS - Universidad de Guadalajara"
                        class="w-8"
                    />
                    <span class="ml-3 text-lg text-white"> ITRANS</span>
                    <span class="ml-2 text-base text-white">UDG</span>
                </a>
            </div>
            <div class="intro-x flex-grow flex items-center w-auto bg-transparent text-black z-20 justify-end pr-4 mr-2">
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <x-base.button
                                as="a"
                                href="{{ url('/dashboard') }}"
                                variant="dark"
                                rounded
                            >
                                {{ __('Dashboard') }}
                            </x-base.button>
                        @else
                            <x-base.button
                                as="a"
                                href="{{ route('login') }}"
                                variant="dark"
                                rounded
                            >
                                {{ __('Log in') }}
                            </x-base.button>

                            @if (Route::has('register'))
                                <x-base.button
                                    as="a"
                                    href="{{ route('register') }}"
                                    variant="dark"
                                    rounded
                                >
                                    {{ __('Register') }}
                                </x-base.button>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
        <hr class="border-b border-gray-100 opacity-25 my-0 py-0">
    </nav>

    <div>
        <!-- BG IMAGE con desvanecido -->
        <img src="{{ Vite::asset('resources/images/bg-image.jpg') }}"
            alt="Imagen de fondo"
            class="absolute right-0 hidden xl:block w-[45%] h-full -mt-[0%] -ml-[13%] transform opacity-70 z-10 object-cover user-select:none"
            style="mask-image: linear-gradient(to right, rgba(0, 0, 0, 0.0) 0%, rgb(0, 0, 0) 30%, rgba(0, 0, 0, 1) 100%);"
        />

        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#064E3B] selection:text-white z-10">
            <div class="max-w-screen-2xl mx-auto md:px-6 lg:px-8">
                <header class="w-full text-center">
                    <div class="-intro-x mt-10 text-4xl font-bold leading-tight">
                        <span class="flex flex-col md:flex-row items-center md:items-end">
                            <x-base.lucide
                                icon="microscope"
                                class="h-16 w-16 mr-2"
                            />
                            {{ config('app.name') }}
                        </span>
                    </div>
                </header>

                <main class="w-full md:w-2/3 mt-6">
                    <div class="-intro-x mt-5 text-xl leading-tight text-justify mx-5">
                        Repositorio de imágenes sobre muestras biológicas recolectadas a través de un microscopio electrónico de barrido.
                    </div>

                    <div class="text-center md:text-left">
                        <x-base.button
                            as="a"
                            href="{{ route('login') }}"
                            variant="primary"
                            size="lg"
                            class="-intro-x mt-10 w-1/2 h-16 uppercase p-4 md:p-0"
                            rounded
                        >
                            Ingresar al sistema
                        </x-base.button>
                    </div>
                </main>

                <footer class="w-full md:w-1/2 pt-24">
                    <div class="-intro-x flex flex-col md:flex-row text-center justify-center md:justify-between text-sm text-black">
                        <div>
                            Universidad de Guadalajara © 2025
                        </div>
                        <div>
                            <a href="microscopia.itrans@cucei.udg.mx" class="text-blue-500">
                                microscopia.itrans@cucei.udg.mx
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endSection
