<?php

namespace App\Console\Commands;

use App\Enums\Permissions\RolePermission;
use App\Enums\RoleEnum;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando permite actualizar los roles y permisos en producción.';

    /**
     * Especifíca aquí los enums de los permisos a actualizar.
     *
     * @var array
     */
    protected $permissionEnums = [
        RolePermission::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->updateRoles();
        $this->updatePermissions();

        $this->call('optimize:clear');
        $this->info('Todos los cachés han sido limpiados después de actualizar los permisos.');
    }

    private function updateRoles()
    {
        foreach (RoleEnum::values() as $nombreRol) {
            Role::findOrCreate($nombreRol, 'web');
        }
    }

    private function updatePermissions()
    {
        foreach ($this->permissionEnums as $enum) {
            if (method_exists($enum, 'map')) {
                $permisosMap = $enum::map();
            } else {
                $this->info(" - El enum $enum no tiene un método map(), se omitirá el mapeo de permisos a roles.");
                continue;
            }

            foreach ($enum::cases() as $permiso) {
                $permission = Permission::findOrCreate($permiso->value, 'web');

                if ($permission->wasRecentlyCreated) {
                    $permission->syncRoles($permisosMap[$permiso->value]);
                }
            }
        }
    }
}
