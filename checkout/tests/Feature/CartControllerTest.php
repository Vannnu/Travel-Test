<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\Constant\CartControllerCostant;
use Tests\Constant\TravelModelCostant;
use Tests\TestCase;

/**
 * Class CartControllerTest.
 */
class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the index method of CartController returns cart data
     * and requires the 'email' parameter in the request.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function indexShouldReturnCartData(): void
    {
        $travel = new Travel();
        $travel->fill(TravelModelCostant::TRAVEL_DATA)
               ->save();

        /** @var Cart $cart */
        $cart = Cart::factory()->create([
            'travel_id' => $travel->id,
            'status' => Cart::ACTIVE,
        ]);

        self::assertNotNull($cart);

        $response = $this->json('GET', route('carts.index') . '?email=' . $cart->email);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(CartControllerCostant::API_INDEX_RESPONSE_STRUCTURE);
    }

    /**
     * Test that the Create method of CartController returns cart data.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function createShouldCreateCart(): void
    {
        $travel = new Travel();
        $travel->fill(TravelModelCostant::TRAVEL_DATA)
               ->save();

        $data = [
            'email' => 'user@example.com',
            'travel_id' => $travel->id,
            'reserved_seat' => 2,
        ];

        $response = $this->json('POST', route('carts.create'), $data);

        $response->assertJsonStructure(CartControllerCostant::API_CREATE_RESPONSE_STRUCTURE)
                 ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test that the create method throws a BadRequestHttpException
     * when there are not enough available seats.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function createShouldThrowExceptionIfNotEnoughSeats(): void
    {
        /** @var Travel $travel */
        $travel = Travel::factory()->create([
            'seat_capacity' => 10,
        ]);

        $data = [
            'email' => 'user@example.com',
            'travel_id' => $travel->id,
            'reserved_seat' => 20,
        ];

        $response = $this->json('POST', route('carts.create'), $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $response->assertJsonFragment([
            'message' => 'Non ci sono abbastanza posti disponibili',
        ]);
    }

    /**
     * Test that the create method throws a BadRequestHttpException
     * if a cart already exists for the same travel and email.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function createShouldThrowExceptionIfCartAlreadyExists(): void
    {
        /** @var Travel $travel */
        $travel = Travel::factory()->create([
            'seat_capacity' => 10,
        ]);

        $data = [
            'email' => 'user@example.com',
            'travel_id' => $travel->id,
            'reserved_seat' => 1,
            'status' => Cart::ACTIVE,
        ];

        $cart = Cart::factory()->create($data);

        self::assertNotNull($cart);

        $response = $this->json('POST', route('carts.create'), $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $response->assertJsonFragment([
            'message' => "Hai gia un cart attivo per il viaggio: {$travel->name}",
        ]);
    }
}
