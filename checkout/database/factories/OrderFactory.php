<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'transaction_id' => $this->faker->uuid,
            'status' => $this->faker->numberBetween(0, 2), // Assuming 0: Pending, 1: Completed, 2: Failed
            'total_amount' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
