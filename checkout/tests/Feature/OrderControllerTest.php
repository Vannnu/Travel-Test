<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\Constant\OrderControllerConstant;
use Tests\TestCase;

/**
 * Class OrderControllerTest.
 */
class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the 'create' method to create a new order.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function createShouldCreateOrder(): void
    {
        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();

        /** @var Travel $travel */
        $travel = Travel::factory()->create();

        /** @var Cart $cart */
        $cart = Cart::factory()->create([
            'travel_id' => $travel->id,
            'status' => Cart::ACTIVE,
        ]);

        $data = [
            'cart_id' => $cart->id,
            'total_amount' => 100.00,
            'payment_method_id' => $paymentMethod->id,
            'transaction_id' => '1234asdfgczs4567',
        ];

        $response = $this->json('POST', route('orders.create'), $data);

        $response->assertJsonStructure(OrderControllerConstant::API_CREATE_RESPONSE)
                 ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test the 'create' method with an expired cart.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function createShouldThrowExceptionForExpiredCart(): void
    {
        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();

        $travel = Travel::factory()->create();

        $cart = Cart::factory()->create([
            'travel_id' => $travel->id,
            'status' => Cart::EXPIRED,
        ]);

        $data = [
            'cart_id' => $cart->id,
            'total_amount' => 100.00,
            'payment_method_id' => $paymentMethod->id,
            'transaction_id' => '1234asdfgczs4567',
        ];

        $response = $this->json('POST', route('orders.create'), $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
                 ->assertJsonFragment([
                     'message' => 'Il tuo carrello è Expired. Non hai più posti riservati',
                 ]);
    }
}
