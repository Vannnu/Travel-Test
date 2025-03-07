<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TravelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if travel is created correctly.
     *
     * @return void
     */
    #[Test]
    public function itCreatesATravel(): void
    {
        Travel::factory()->create([
            'slug' => 'paris-trip',
            'name' => 'Paris Trip',
            'starting_date' => '2025-05-01',
            'ending_date' => '2025-05-07',
            'price' => 1000,
            'seat_capacity' => 50,
            'reserved_seat_number' => 10,
            'url_images' => json_encode(['image1.jpg', 'image2.jpg']),
            'departure_location' => 'Rome',
            'is_active' => 1,
        ]);

        $this->assertDatabaseHas('travels', [
            'slug' => 'paris-trip',
            'name' => 'Paris Trip',
            'price' => 1000,
            'seat_capacity' => 50,
            'reserved_seat_number' => 10,
        ]);
    }

    /**
     * Test if the duration of the Travel is calculated correctly.
     *
     * @return void
     */
    #[Test]
    public function itCalculatesTheDurationCorrectly(): void
    {
        $travel = Travel::factory()->create([
            'starting_date' => '2025-05-01',
            'ending_date' => '2025-05-07',
        ]);

        $this->assertSame(6, $travel->duration);
    }

    /**
     * Test if the availability of seats is calculated correctly.
     *
     * @return void
     */
    #[Test]
    public function itCalculatesTheAvailabilityCorrectly(): void
    {
        $travel = Travel::factory()->create([
            'seat_capacity' => 50,
            'reserved_seat_number' => 10,
        ]);

        $this->assertSame(40, $travel->availability); // 50 - 10 = 40 available seats
    }

    /**
     * Test the scopeSearchQuery functionality.
     *
     * @return void
     */
    #[Test]
    public function itFiltersTravelsBasedOnQuery(): void
    {
        Travel::factory()->create([
            'name' => 'Paris Trip',
            'price' => 1000,
            'starting_date' => '2025-05-01',
            'ending_date' => '2025-05-07',
            'seat_capacity' => 50,
            'reserved_seat_number' => 10,
        ]);

        Travel::factory()->create([
            'name' => 'London Trip',
            'price' => 1200,
            'starting_date' => '2025-06-01',
            'ending_date' => '2025-06-07',
            'seat_capacity' => 40,
            'reserved_seat_number' => 5,
        ]);

        $filters = [
            'q.name' => 'Paris',
            'q.price_min' => 500,
            'q.price_max' => 1500,
            'q.starting_date' => '2025-05-01',
            'q.take' => 10,
        ];

        $travels = (new Travel())->scopeSearchQuery($filters)->items();

        $this->assertCount(1, $travels);
        $this->assertSame('Paris Trip', $travels[0]->name);
    }
}
