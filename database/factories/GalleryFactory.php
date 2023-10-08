<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> 
     */
    public function definition()
    {
        return [
            "name" => fake()->sentence(2),
            "description" => fake()->text(100),
            "urls" => json_encode([fake()->imageUrl(640, 480, 'jpg'), fake()->imageUrl(640, 480, 'jpg'), fake()->imageUrl(640, 480, 'jpg')]),
            "user_id" => User::all()->random(1)->first()->id 
        ];
    }
}

