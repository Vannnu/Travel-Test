<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TravelControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the 'index' method to search and return paginated travel records.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function indexShouldReturnPaginatedTravelRecords(): void
    {
        Travel::factory()->count(5)->create();

        $response = $this->json('GET', route('travels.index'));

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure();
    }

    /**
     * Test the 'show' method to fetch a travel record by UUID.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function showShouldReturnTravelRecord(): void
    {
        $travel = Travel::factory()->create();

        $response = $this->json('GET', route('travels.show', ['uuid' => $travel->id]));

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure();
    }
}
