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
            'name' => 'modelname' . '_' .time(),
            'base_model' => fake()->randomElement(AvailableModelsEnum::values()),
            'val_accuracy' => '9' . fake()->randomNumber(),
            'val_error' => '0.0123' . fake()->randomNumber(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (CnnModel $cnnModel) {
            $cnnModel->name = pathinfo($cnnModel->base_model, PATHINFO_FILENAME) . '_' .time() . '.keras';
            $cnnModel->save();

            $cnnModel->labels()->sync(
                Label::inRandomOrder()
                    ->limit(3)
                    ->get()
                    ->pluck('id')
            );

            $cnnModel->addMedia(resource_path($cnnModel->base_model))
                ->preservingOriginal()
                ->toMediaCollection(MediaEnum::CNN_Model->value);
        });
    }
}
