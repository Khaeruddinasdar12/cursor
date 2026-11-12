<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Document> */
class DocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'category' => fake()->randomElement(['Panduan', 'Formulir', 'Prosedur', 'Template']),
            'description' => fake()->sentence(10),
            'icon' => 'fa-solid fa-file-lines',
            'file_type' => 'PDF',
            'file_size' => '1.0 MB',
            'sort' => 0,
            'is_active' => true,
        ];
    }
}
