<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
{
    /**
     * Instance variable.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'email' => $this->faker->email(),
            'travel_id' => Travel::factory(),
            'reserved_seat' => $this->faker->numberBetween(1, 10),
            'expiration_time' => now(),
            'status' => $this->faker->randomElement([Cart::ACTIVE, Cart::EXPIRED, Cart::PURCHASED]),
            'total_amount' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
