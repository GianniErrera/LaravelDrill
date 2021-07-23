<?php

namespace Database\Factories;

use App\Models\EventInstance;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventInstanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventInstance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'eventDescription' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'isItRecurringYearly' => (bool)random_int(0, 1)
        ];
    }
}
