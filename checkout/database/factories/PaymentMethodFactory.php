<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid, // Assuming a UUID is used as the primary key
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
