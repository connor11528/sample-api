<?php

namespace Database\Factories;

use App\Models\Capybara;
use Illuminate\Database\Eloquent\Factories\Factory;

class CapybaraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Capybara::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'color' => $this->faker->colorName,
            'size' => $this->faker->randomElement([
                'Big',
                'Medium',
                'Small'
            ])
        ];
    }
}
