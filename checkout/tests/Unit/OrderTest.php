<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Class OrderTest.
 */
class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the order belongs to a cart.
     *
     * @return void
     */
    #[Test]
    public function itBelongsToACart(): void
    {
        $cart = Cart::factory()->create();
        $order = Order::factory()->create(['cart_id' => $cart->id]);

        $this->assertSame($cart->id, $order->cart->id);
    }

    /**
     * Test if the order belongs to a payment method.
     *
     * @return void
     */
    #[Test]
    public function itBelongsToAPaymentMethod(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();
        $order = Order::factory()->create(['payment_method_id' => $paymentMethod->id]);

        $this->assertSame($paymentMethod->id, $order->paymentMethod->id);
    }

    /**
     * Test if the `orderPersist` method updates the cart status and creates an order.
     *
     * @return void
     */
    #[Test]
    public function itPersistsAnOrderAndUpdatesCartStatus(): void
    {
        $cart = Cart::factory()->create();
        $orderData = [
            'cart_id' => $cart->id,
            'payment_method_id' => PaymentMethod::factory()->create()->id,
            'transaction_id' => '1234-5678',
            'status' => 1, // Completed
            'total_amount' => 5000,
        ];

        $order = new Order();
        $order->orderPersist($cart, $orderData);

        $cart->refresh();

        // Assert that the order has been created and the cart status has been updated
        $this->assertDatabaseHas('orders', ['transaction_id' => '1234-5678']);
        $this->assertSame(Cart::PURCHASED, $cart->status);
    }
}
