@vite('resources/css/app.css')

<div class="fixed pin-t pin-x z-40">
    <div class="bg-gradient-primary h-3"></div>

    <nav class="flex flex-col sm:flex-row items-start sm:items-center gap-y-2 sm:gap-y-0 py-2 sm:py-0 justify-between bg-secondary shadow-xs h-30 xl:h-16">
        <div class="flex items-center justify-between flex-no-shrink">
            <a href="{{ url('/dashboard') }}" class="flex items-center flex-no-shrink mx-4">
                @include("larecipe::partials.logo")

                <p class="inline-block mx-1">
                    {{ config('app.name') }}
                </p>
            </a>

            <div class="switch">
                <x-base.form-switch>
                    <x-base.form-switch.input
                        id="1"
                        name="1"
                        type="checkbox"
                        v-model="sidebar"
                    />
                    <x-base.form-switch.label for="1" class="block sm:hidden">
                        {{ __('Collapse') }}
                    </x-base.form-switch.label>
                </x-base.form-switch>
            </div>

            <span class="text-lg ml-2 hidden md:block">
                {{ __("User's manual") }}
            </span>
        </div>

        <div class="mx-4 flex items-end">
            @if(config('larecipe.search.enabled'))
                <larecipe-button id="search-button"
                    :type="searchBox ? 'primary' : 'link'"
                    @click="searchBox = ! searchBox"
                    class="px-4">
                    <i class="fas fa-search" id="search-button-icon"></i>
                </larecipe-button>
            @endif

            {{-- versions dropdown --}}
            <larecipe-dropdown>
                <larecipe-button type="primary" size="sm" class="flex items-center">
                    <span class="hidden sm:block mr-2">
                        {{ __('Version') }}
                    </span>
                    {{ $currentVersion }} <i class="mx-1 fa fa-angle-down"></i>
                </larecipe-button>

                <template slot="list">
                    <ul class="list-reset">
                        @foreach ($versions as $version)
                            <li class="py-2 hover:bg-grey-lightest">
                                <a class="px-6 text-grey-darkest" href="{{ route('larecipe.show', ['version' => $version, 'page' => $currentSection]) }}">{{ $version }}</a>
                            </li>
                        @endforeach
                    </ul>
                </template>
            </larecipe-dropdown>
            {{-- /versions dropdown --}}

            <larecipe-button href="{{ url('/dashboard') }}" type="white" size="sm" class="mx-2 h-11 sm:h-auto px-4">
                <a href="{{ url('/dashboard') }}" class="flex items-center flex-no-shrink mx-4">
                    <i class="fa fa-rotate-left"></i>
                    <span class="hidden sm:block ml-2">
                        {{ __('Return') }}
                    </span>
                </a>
            </larecipe-button>
        </div>
    </nav>
</div>
