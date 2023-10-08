<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state. 
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "description" => fake()->text(50),
            "user_id" => User::all()->random(1)->first()->id,
            "gallery_id" => Gallery::all()->random(1)->first()->id 
        ];
    }
}

