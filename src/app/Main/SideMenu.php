<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     */
    public static function menu(): array
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'title' => __('Dashboard'),
                'route_name' => 'dashboard',
            ],

            'divider',

            'role.*' => [
                'icon' => 'shield-ellipsis',
                'title' => __('Roles'),
                'route_name' => 'role.index',
            ],
            'user.*' => [
                'icon' => 'users',
                'title' => __('Users'),
                'route_name' => 'login',
            ],

            'divider',

            'imagen.*' => [
                'icon' => 'images',
                'title' => __('Image management'),
                'route_name' => 'login',
            ],
        ];
    }
}
