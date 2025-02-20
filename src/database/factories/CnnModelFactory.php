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
            'name' => 'modelname',
            'base_model' => fake()->randomElement(AvailableModelsEnum::values()),
            'accuracy' => (double)('0.9' . fake()->randomNumber(nbDigits: 3)),
            'loss' => (double)('0.01' . fake()->randomNumber(nbDigits: 2)),
            'val_accuracy' => (double)('0.9' . fake()->randomNumber(nbDigits: 3)),
            'val_loss' => (double)('0.01' . fake()->randomNumber(nbDigits: 2)),
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
