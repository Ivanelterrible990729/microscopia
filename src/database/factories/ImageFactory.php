<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Label;
use App\Models\User;
use App\Services\MediaImageService;
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

            $labelName = $image->labels->first()->folder_name;
            $mediaImageService = new MediaImageService();
            $mediaImageService->addMedia(
                image: $image,
                file: resource_path('images/dataset/' . sanitizeFileName($labelName) . '.jpg'),
                preservingOriginal: true
            );
        });
    }
}
