<aside
    x-data="{ selected: '' }"
    :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
    <!-- SIDEBAR HEADER -->
    <div
        :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="sidebar-header flex items-center gap-2 pt-8 pb-7"
    >
        <a href="{{ route('be.dashboard.index') }}">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo"/>
                <img class="hidden dark:block" src="{{ asset('assets/images/logo/logo-dark.svg') }}" alt="Logo"/>
            </span>
            <img
                class="logo-icon"
                :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('assets/images/logo/logo-icon.svg') }}"
                alt="Logo"
            />
        </a>
    </div>
    <!-- END SIDEBAR HEADER -->

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav>
            @php

                $menus = collect([
                    [
                        'order' => 1,
                        'children' => [[
                            'type' => 'single',
                            'label' => 'Dashboard',
                            'icon' => 'bx-grid-alt',
                            'route' => 'be.dashboard.index',
                            'active' => ['be.dashboard', 'be.dashboard.*'],
                            // kalau Anda mau nonaktifkan permission, cukup hapus baris di bawah:
                            // 'permission' => PermissionEnum::READ_DASHBOARD,
                        ]],
                    ],
                ]);

                $user = Auth::user();

                $filteredMenus = $menus->map(function ($menu) use ($user) {
                    $children = collect($menu['children']);

                    // Kalau semua child tidak punya key 'permission', lewati filtering
                    $shouldFilter = $children->contains(fn($child) => !empty($child['permission'] ?? null));

                    if ($shouldFilter) {
                        $children = $children->filter(fn($child) =>
                            !isset($child['permission']) || $user->can($child['permission'])
                        );
                    }

                    return [
                        ...$menu,
                        'children' => $children->sortBy('order'),
                    ];
                })
                ->filter(fn($menu) => $menu['children']->isNotEmpty())
                ->sortBy('order');
            @endphp

            <div class="mt-5 lg:mt-0">
                @foreach ($filteredMenus as $menu)
                    @if (!empty($menu['title']))
                        <h3 class="my-3 text-xs uppercase leading-[20px] text-gray-400">
                            {{ $menu['title'] }}
                        </h3>
                    @endif

                    <ul class="mb-2 flex flex-col gap-2">
                        @foreach ($menu['children'] as $child)
                            @switch($child['type'] ?? 'single')

                                {{-- DROPDOWN --}}
                                @case('dropdown')
                                    @php
                                        $hasActiveChild = collect($child['children'])->contains(
                                            fn($sub) => is_active($sub['active'] ?? [])
                                        );
                                    @endphp
                                    <li>
                                        <a
                                            href="#"
                                            @click.prevent="selected = (selected === '{{ $child['label'] }}' ? '' : '{{ $child['label'] }}')"
                                            x-init="@if($hasActiveChild) selected = '{{ $child['label'] }}' @endif"
                                            class="menu-item group"
                                            :class="selected === '{{ $child['label'] }}' ? 'menu-item-active' : 'menu-item-inactive'"
                                        >
                                            <i class="bx bx-sm {{ $child['icon'] }}"></i>
                                            <span
                                                class="menu-item-text"
                                                :class="sidebarToggle ? 'lg:hidden' : ''"
                                            >
                                                {{ $child['label'] }}
                                            </span>
                                            <i
                                                class="bx bx-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2"
                                                :class="[
                                                    selected === '{{ $child['label'] }}'
                                                        ? 'menu-item-arrow-active'
                                                        : 'menu-item-arrow-inactive',
                                                    sidebarToggle ? 'lg:hidden' : ''
                                                ]"
                                                style="font-size: 20px;"
                                            ></i>
                                        </a>

                                        <div
                                            class="overflow-hidden transform translate"
                                            :class="selected === '{{ $child['label'] }}' ? 'block' : 'hidden'"
                                        >
                                            <ul
                                                class="menu-dropdown mt-2 flex flex-col gap-2 pl-9"
                                                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                            >
                                                @foreach ($child['children'] as $sub)
                                                    @php
                                                        $href = $sub['url'] ?? $sub['uri'] ?? (!empty($sub['route']) ? route($sub['route']) : '#');
                                                        $subActive = is_active($sub['active'] ?? []);
                                                    @endphp
                                                    <li>
                                                        <a
                                                            href="{{ $href }}"
                                                            class="menu-dropdown-item group {{ $subActive ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                                        >
                                                            {{-- Icon hanya tampil jika ada --}}
                                                            @if(!empty($sub['icon']))
                                                                <i class="bx bx-sm {{ $sub['icon'] }}"></i>
                                                            @endif
                                                            <span>{{ $sub['label'] }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    @break

                                {{-- SINGLE --}}
                                @case('single')
                                @default
                                    @php
                                        $href = $child['url'] ?? $child['uri'] ?? (!empty($child['route']) ? route($child['route']) : '#');
                                        $isActive = is_active($child['active'] ?? []);
                                    @endphp
                                    <li>
                                        <a
                                            href="{{ $href }}"
                                            class="menu-item group {{ $isActive ? 'menu-item-active' : 'menu-item-inactive' }}"
                                        >
                                            <i class="bx bx-sm {{ $child['icon'] }}"></i>
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                            @endswitch
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </nav>
    </div>
</aside>