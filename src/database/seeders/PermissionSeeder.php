<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Permission::exists()) {
            $this->command->comment('- Ya hay registros en la base de datos. Seeder suspendido [Database\Seeders\PermissionSeeder.php].');
            return;
        }

        if (! is_dir($directorio = app_path('Enums/Permissions'))) {
            $this->command->comment("- El directorio $directorio no existe. Seeder suspendido [Database\Seeders\PermissionSeeder.php].");
            return;
        }

        $enums = [];
        $pathEnums = glob(app_path('Enums/Permissions/*.php'));

        foreach ($pathEnums as $pathEnum) {
            $className = str_replace([app_path('Enums/Permissions/'), '.php'], '', $pathEnum);
            $enums[] = "App\Enums\Permissions\\$className";
        }

        foreach ($enums as $enum) {
            if (method_exists($enum, 'map')) {
                $permisosMap = $enum::map();
            } else {
                $this->command->info(" - El enum $enum no tiene un método map(), se omitirá el mapeo de permisos a roles.");
                continue;
            }

            foreach ($enum::cases() as $permiso) {
                $permission = Permission::create(['name' => $permiso->value]);
                $permission->syncRoles($permisosMap[$permiso->value]);
            }
        }
    }
}
