<?php

namespace Database\Factories;

use App\Models\LoanPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'loan_id' => 1,
            'amount' => $this->faker->randomFloat(2),
            'start_at' => $this->faker->date,
            'end_at' => $this->faker->date,
            'status' => array_rand(['processing','done']),
        ];
    }
}
