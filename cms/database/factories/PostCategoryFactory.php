<?php

namespace Database\Factories;

use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PostCategory> */
class PostCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return ['name' => ucfirst($name), 'slug' => $name, 'sort' => 0];
    }
}
