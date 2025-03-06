<?php

namespace App\Main;

use App\Models\CnnModel;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class SideMenu
{
    /**
     * List of side menu items.
     */
    public static function menu(): array
    {
        $menu = [
            'dashboard' => [
                'icon' => 'home',
                'title' => __('Dashboard'),
                'route_name' => 'dashboard',
                'permission' => 'none',
            ],

            'divider',

            'role.*' => [
                'icon' => 'shield-ellipsis',
                'title' => __('Roles'),
                'route_name' => 'role.index',
                'policy' => 'viewAny',
                'model' => Role::class,
            ],
            'user.*' => [
                'icon' => 'users',
                'title' => __('Users'),
                'route_name' => 'user.index',
                'policy' => 'viewAny',
                'model' => User::class,
            ],
            'activitylog.*' => [
                'icon' => 'square-activity',
                'title' => __('Activity log'),
                'route_name' => 'activitylog.index',
                'policy' => 'viewAny',
                'model' => Activity::class,
            ],

            'divider',

            'cnn-model.*' => [
                'icon' => 'brain-circuit',
                'title' => __('CNN Models'),
                'route_name' => 'cnn-model.index',
                'policy' => 'viewAny',
                'model' => CnnModel::class,
            ],
            'image.*' => [
                'icon' => 'images',
                'title' => __('Image management'),
                'route_name' => 'image.index',
                'policy' => 'viewAny',
                'model' => Image::class,
            ],
        ];

        return self::filterMenu($menu);
    }

    /**
     * Filtra las opciones del menú según permisos o policies.
     */
    protected static function filterMenu(array $menu): array
    {
        return array_filter($menu, function ($item) {
            // Permitir dividers o elementos que no tienen restricciones
            if ($item === 'divider' || !is_array($item)) {
                return true;
            }

            $user = request()->user();

            // Verificar permisos de Spatie
            if (isset($item['permission'])) {
                if ($item['permission'] == 'none') {
                    return true;
                }

                return $user?->can($item['permission']);
            }

            // Verificar Policies si están definidas
            if (isset($item['policy']) && isset($item['model']) && Gate::allows($item['policy'], $item['model'])) {
                return true;
            }

            return false;
        });
    }
}
