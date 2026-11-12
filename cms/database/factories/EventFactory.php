<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Event> */
class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'event_date' => now()->addDays(fake()->numberBetween(1, 30))->toDateString(),
            'time' => '09.00 WITA',
            'location' => 'Aula LPPM IAIN Bone',
            'is_published' => true,
        ];
    }
}
