<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Role::exists()) {
            $this->command->comment('- Ya hay registros en la base de datos. Seeder suspendido [Database\Seeders\RoleSeeder.php].');
            return;
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (RoleEnum::values() as $nombreRol) {
            Role::create(['name' => $nombreRol]);
        }
    }
}
