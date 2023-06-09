<?php

namespace Database\Factories;

use App\Enums\ExpenseCategory;
use App\Enums\ExpensePaymentMethod;
use App\Enums\ExpensePaymentStatus;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'category' => ExpenseCategory::getRandomValue(),
            'value' => $this->faker->randomFloat(2, 0, 10000),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'person_to_pay' => $this->faker->name(),
            'payment_method' => ExpensePaymentMethod::getRandomValue(),
            'payment_status' => ExpensePaymentStatus::getRandomValue(),
            'installments' => $this->faker->randomNumber(1, 24),
        ];
    }
}
