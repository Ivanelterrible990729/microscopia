<?php

namespace Database\Factories;

use App\Enums\Media\MediaEnum;
use App\Models\Image;
use App\Models\Label;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => fake()->name() . '.' . fake()->fileExtension(),
            'description' => fake()->text(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Image $image) {
            $image->labels()->sync(
                Label::inRandomOrder()
                    ->limit(1)
                    ->get()
                    ->pluck('id')
            );

            $labelName = $image->labels->first()->name;
            $image->addMedia(resource_path('images/dataset/' . $labelName . '.jpg'))
                ->preservingOriginal()
                ->toMediaCollection(MediaEnum::Images->value);
        });
    }
}
