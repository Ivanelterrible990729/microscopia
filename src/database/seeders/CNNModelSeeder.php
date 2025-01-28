<?php

namespace Database\Seeders;

use App\Models\CNNModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CNNModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (CNNModel::exists()) {
            $this->command->comment('- Ya hay registros en la base de datos. Seeder suspendido [Database\Seeders\CNNModelSeeder.php].');
            return;
        }

        CNNModel::create([
            'name' => 'VGG16',
        ]);

        CNNModel::create([
            'name' => 'MobileNet v2',
        ]);

        CNNModel::create([
            'name' => 'AlexNet',
        ]);
    }
}
