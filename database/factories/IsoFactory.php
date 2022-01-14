<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Iso;

class IsoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Iso::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'business_name' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'contact_name' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'contact_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'emails' => $this->faker->text,
        ];
    }
}
