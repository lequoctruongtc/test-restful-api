<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'amount' => $this->faker->numberBetween(10000, 999999),
            'term' => $this->faker->numberBetween(1, 12),
            'term_type' => array_rand(['months', 'years']),
            'status' => 'pending',
        ];
    }
}
