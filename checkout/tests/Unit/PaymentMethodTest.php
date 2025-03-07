<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Class PaymentMethodTest.
 */
class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if a PaymentMethod is created correctly.
     *
     * @return void
     */
    #[Test]
    public function itCreatesAPaymentMethod(): void
    {
        PaymentMethod::factory()->create([
            'name' => 'Credit Card',
            'description' => 'Payment via credit card',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'name' => 'Credit Card',
            'description' => 'Payment via credit card',
            'is_active' => true,
        ]);
    }

    /**
     * Test the relationship between PaymentMethod and Orders.
     *
     * @return void
     */
    #[Test]
    public function itHasManyOrders(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();
        $order = Order::factory()->create([
            'payment_method_id' => $paymentMethod->id,
        ]);

        $this->assertTrue($paymentMethod->orders->contains($order));
    }

    /**
     * Test if the PaymentMethod is inactive when is_active is false.
     *
     * @return void
     */
    #[Test]
    public function itCreatesInactivePaymentMethod(): void
    {
        $paymentMethod = PaymentMethod::factory()->create([
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'id' => $paymentMethod->id,
            'is_active' => false,
        ]);
    }

    /**
     * Test checking the activation status of a PaymentMethod.
     *
     * @return void
     */
    #[Test]
    public function itChecksIfPaymentMethodIsActive(): void
    {
        /** @var PaymentMethod $activePaymentMethod */
        $activePaymentMethod = PaymentMethod::factory()->create([
            'is_active' => true,
        ]);

        /** @var PaymentMethod $inactivePaymentMethod */
        $inactivePaymentMethod = PaymentMethod::factory()->create([
            'is_active' => false,
        ]);

        $this->assertTrue($activePaymentMethod->is_active);
        $this->assertFalse($inactivePaymentMethod->is_active);
    }
}
