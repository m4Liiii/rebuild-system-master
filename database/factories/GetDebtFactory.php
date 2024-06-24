<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GetDebt>
 */
class GetDebtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerId = Customer::inRandomOrder()->first()->id ?? Customer::factory()->create()->id;
        $userId = User::inRandomOrder()->first()->id ?? User::factory()->create()->id;
        $s_id = $this->faker->unique()->numberBetween(1, 20000);
        return [

                'customer_id' => $customerId,
                'user_id' => $userId,
                's_id' =>$s_id,
                'old_debt' => $this->faker->numberBetween(1, 2000),
                'amount_of_debt' => $this->faker->numberBetween(1, 2000),
                'new_debt' => $this->faker->numberBetween(1, 2000),
                'discount' => $this->faker->numberBetween(1, 2000),
                'curr' => 1,
                'name_of_recipient' => $this->faker->name,
                'name_of_office' => $this->faker->company,
                'notice_of_debt' => $this->faker->sentence,
                'created_at' => now(),
                'type_notice' => 1,
                'type_price' => 1,
                'type_amount' => 1,
                'delivery'=>1,
                'type_invoice' => 1,
                'amount_dollar' => 0,
                'amount_dinar' => 0,
                'type_delete' => 1,

        ];
    }
}
