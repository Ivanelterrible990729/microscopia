<!-- BEGIN: Side Menu -->
<nav class="side-nav z-50 -mt-4 hidden w-[100px] overflow-x-hidden px-5 pb-16 pt-32 md:block xl:w-[260px]">
    <ul>
        @foreach ($mainMenu as $menuKey => $menu)
            @if ($menu == 'divider')
                <li class="side-nav__divider my-6"></li>
            @else
                <li>
                    <a
                        href="{{ isset($menu['route_name']) ? route($menu['route_name'], isset($menu['params']) ? $menu['params'] : []) : 'javascript:;' }}"
                        @class([
                            ($firstLevelActiveIndex == $menuKey || request()->routeIs($menuKey))
                                ? 'side-menu side-menu--active'
                                : 'side-menu',
                        ])
                    >
                        <div class="side-menu__icon">
                            <x-base.lucide icon="{{ $menu['icon'] }}" />
                        </div>
                        <div class="side-menu__title">
                            {{ $menu['title'] }}
                            @if (isset($menu['sub_menu']))
                                <div
                                    class="side-menu__sub-icon {{ ($firstLevelActiveIndex == $menuKey || request()->routeIs($menuKey)) ? 'transform rotate-180' : '' }}">
                                    <x-base.lucide icon="ChevronDown" />
                                </div>
                            @endif
                        </div>
                    </a>
                    @if (isset($menu['sub_menu']))
                        <ul class="{{ ($firstLevelActiveIndex == $menuKey || request()->routeIs($menuKey)) ? 'side-menu__sub-open' : '' }}">
                            @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                <li>
                                    <a
                                        href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], isset($subMenu['params']) ? $subMenu['params'] : []) : 'javascript:;' }}"
                                        @class([
                                            ($secondLevelActiveIndex == $subMenuKey || request()->routeIs($subMenuKey))
                                                ? 'side-menu side-menu--active'
                                                : 'side-menu',
                                        ])
                                    >
                                        <div class="side-menu__icon">
                                            <x-base.lucide icon="{{ $subMenu['icon'] }}" />
                                        </div>
                                        <div class="side-menu__title">
                                            {{ $subMenu['title'] }}
                                            @if (isset($subMenu['sub_menu']))
                                                <div
                                                    class="side-menu__sub-icon {{ ($secondLevelActiveIndex == $subMenuKey || request()->routeIs($subMenuKey)) ? 'transform rotate-180' : '' }}">
                                                    <x-base.lucide icon="ChevronDown" />
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    @if (isset($subMenu['sub_menu']))
                                        <ul
                                            class="{{ ($secondLevelActiveIndex == $subMenuKey || request()->routeIs($subMenuKey)) ? 'side-menu__sub-open' : '' }}">
                                            @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                <li>
                                                    <a
                                                        href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], isset($lastSubMenu['params']) ? $lastSubMenu['params'] : []) : 'javascript:;' }}"
                                                        @class([
                                                            ($thirdLevelActiveIndex == $lastSubMenuKey || request()->routeIs($lastSubMenuKey))
                                                                ? 'side-menu side-menu--active'
                                                                : 'side-menu',
                                                        ])
                                                    >
                                                        <div class="side-menu__icon">
                                                            <x-base.lucide icon="{{ $lastSubMenu['icon'] }}" />
                                                        </div>
                                                        <div class="side-menu__title">
                                                            {{ $lastSubMenu['title'] }}
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach

        <li class="side-nav__divider my-6"></li>

        <li>
            <x-base.button
                class="px-4 py-3 bg-white dark:bg-slate-700 hover:bg-white/70 border rounded-lg w-full hover:text-primary"
                as="a"
                href="{{ route('larecipe.show', '1.0') }}"
            >
                <x-base.lucide
                    icon="book-text"
                    class="w-5 h-5 mr-2"
                />
                {{ __("User's manual") }}
            </x-base.button>
        </li>
    </ul>
</nav>
<!-- END: Side Menu -->
