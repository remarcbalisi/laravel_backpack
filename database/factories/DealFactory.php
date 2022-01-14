<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Deal;

class DealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'submission_date' => $this->faker->date(),
            'deal_name' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'sales_stage' => $this->faker->regexify('[A-Za-z0-9]{400}'),
        ];
    }
}
