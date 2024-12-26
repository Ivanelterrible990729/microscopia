<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::exists()) {
            $this->command->comment('- Ya hay registros en la base de datos. Seeder suspendido [Database\Seeders\UserSeeder.php].');
            return;
        }

        if (config('app.env') == 'production') {    // Administradores por default
            User::factory()->create([
                'name' => 'Iván Alejandro Alvarez Chávez',
                'email' => 'ivanalejandro290799@gmail.com',
            ]);
        } else {                                // Usuarios de prueba para desarrollo y testing
            foreach (RoleEnum::array() as $roleValue => $roleName) {
                User::factory()->create([
                    'email' => $roleName . '@test.com',
                ])->assignRole($roleValue);
            }
        }
    }
}
