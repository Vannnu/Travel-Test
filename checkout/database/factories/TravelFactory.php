<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Instance variable.
     *
     * @var string
     */
    protected $model = Travel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->word(),
            'description' => $this->faker->word(),
            'moods' => json_encode([$this->faker->word()]),
            'original_seat_capacity' => $this->faker->numberBetween(1, 10),
            'seat_capacity' => $this->faker->numberBetween(1, 10),
            'starting_date' => $this->faker->date(),
            'ending_date' => $this->faker->date(),
            'price' => $this->faker->numberBetween(100, 1000),
            'reserved_seat_number' => 0,
            'url_images' => json_encode([$this->faker->imageUrl()]), // Mock URL image
            'departure_location' => $this->faker->city(),
        ];
    }
}
