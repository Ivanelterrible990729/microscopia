<?php

namespace Database\Factories;

use App\Enums\CnnModel\AvailableModelsEnum;
use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use App\Models\Label;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CnnModel>
 */
class CnnModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(AvailableModelsEnum::values()) . '_' .time() . '.' . fake()->fileExtension(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (CnnModel $cnnModel) {
            $cnnModel->labels()->sync(
                Label::inRandomOrder()
                    ->limit(3)
                    ->get()
                    ->pluck('id')
            );

            // TODO: Cargar los modelos base a partir de resources.
            $cnnModel->addMedia(resource_path('cnn-models/MobileNetV2.h5'))
                ->preservingOriginal()
                ->toMediaCollection(MediaEnum::CNN_Model->value);
        });
    }
}
