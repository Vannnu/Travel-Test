<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\Constant\PaymentControllerConstant;
use Tests\TestCase;

/**
 * Class PaymentControllerTest.
 */
class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the 'index' method to return all active payment methods.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function indexShouldReturnActivePaymentMethods(): void
    {
        PaymentMethod::factory()->create(['is_active' => PaymentMethod::ACTIVE]);
        PaymentMethod::factory()->create(['is_active' => PaymentMethod::NOT_ACTIVE]);

        $response = $this->json('GET', route('payments.index'));

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(PaymentControllerConstant::API_INDEX_RESPONSE)
                 ->assertJsonCount(1);
    }

    /**
     * Test the 'pay' method to simulate a fake payment.
     *
     * @return void
     *
     * @test
     */
    #[Test]
    public function payShouldReturnTransactionIdAndTotalAmount(): void
    {
        /** @var PaymentMethod $method */
        $method = PaymentMethod::factory()->create(['is_active' => PaymentMethod::ACTIVE]);

        /** @var Cart $cart */
        $cart = Cart::factory()->create();

        $data = [
            'payment_method_id' => $method->id,
            'cart_id' => $cart->id,
            'total_amount' => 100.00,
        ];

        $response = $this->json('POST', route('payments.pay'), $data);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(PaymentControllerConstant::API_PAY_RESPONSE);
    }
}
