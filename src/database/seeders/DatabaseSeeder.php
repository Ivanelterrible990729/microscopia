<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,

            // Utilizados para pruebas en desarrollo
            // y primer lanzamiento a producción
            LabelSeeder::class,
            CNNModelSeeder::class,
        ]);
    }
}
