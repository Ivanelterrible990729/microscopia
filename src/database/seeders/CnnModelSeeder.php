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

        $labels = Label::all()->pluck('id');

        $mobileNetV2 = CnnModel::create([
            'name' => 'MobileNetV2 - Trained',
            'base_model' => 'cnn-models/trained/mobilenetv2.keras',
            'accuracy' => 0.9930,
            'loss' => 0.0992,
            'val_accuracy' => 1.0000,
            'val_loss' => 0.0716,
        ]);

        $mobileNetV2->labels()->sync($labels);
        $mobileNetV2->addMedia(resource_path($mobileNetV2->base_model))
            ->preservingOriginal()
            ->toMediaCollection(MediaEnum::CNN_Model->value);
    }
}
