<?php

namespace Database\Seeders;

use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CnnModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (CnnModel::exists()) {
            $this->command->comment('- Ya hay registros en la base de datos. Seeder suspendido [Database\Seeders\CNNModelSeeder.php].');
            return;
        }

        // TODO:
        // Una vez finalizados los modelos, cargarlos en este seeder.

        $mobileNetV2 = CnnModel::create([
            'name' => 'MobileNetV2',
        ]);

        $mobileNetV2->labels()->sync(
            Label::all()
                ->pluck('id')
        );

        $mobileNetV2->addMedia(resource_path('cnn-models/MobileNetV2.h5'))
            ->preservingOriginal()
            ->toMediaCollection(MediaEnum::CNN_Model->value);

        // $vgg16 = CNNModel::create([
        //     'name' => 'VGG16',
        // ]);

        // $alexNet = CNNModel::create([
        //     'name' => 'AlexNet',
        // ]);
    }
}
