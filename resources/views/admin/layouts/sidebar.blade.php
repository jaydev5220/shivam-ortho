@php
    // dd(session('staff_data'));
    $currentloginRoles = is_string($currentloginRole)
        ? array_map('trim', explode(',', $currentloginRole))
        : (array) $currentloginRole;
    // Define menu items dynamically
    $menuItems = [
        [
            'route' => 'admin.home',
            'icon' => 'fa-solid fa-home',
            'label' => 'Dashboard',
            'roles' => null,
        ],
        [
            'route' => 'admin.users',
            'icon' => 'fa-solid fa-users',
            'label' => 'Users',
            'roles' => null,
        ],
        [
            'route' => 'admin.course',
            'icon' => 'fa-solid fa-book',
            'label' => 'Courses',
            'roles' => null,
        ],
        [
            'route' => 'admin.cms',
            'icon' => 'fa-solid fa-cogs',
            'label' => 'Cms',
            'roles' => null,
        ],
        [
            'route' => 'admin.settings',
            'icon' => 'fa-solid fa-cogs',
            'label' => 'Settings',
            'roles' => null,
        ],
    ];

    // Separate the "Dashboard" menu item
    $dashboardItem = array_filter($menuItems, fn($item) => $item['label'] === 'Dashboard');
    $otherItems = array_filter($menuItems, fn($item) => $item['label'] !== 'Dashboard');

    // Sort the remaining items alphabetically by 'label'
    usort($otherItems, fn($a, $b) => strcmp($a['label'], $b['label']));

    // Merge Dashboard first, then the sorted items
    $menuItems = array_merge($dashboardItem, $otherItems);
@endphp


<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!--admin sidebar-->
                @foreach ($menuItems as $item)
                    <li class="{{ $currentRouteName == $item['route'] ? 'active' : '' }}">
                        <a href="{{ route($item['route']) }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
