<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Class CartTest.
 */
class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the cart belongs to a travel.
     *
     * @return void
     */
    #[Test]
    public function itHasATravelRelationship(): void
    {
        $travel = Travel::factory()->create();
        $cart = Cart::factory()->create(['travel_id' => $travel->id]);

        $this->assertSame($travel->id, $cart->travel->id);
    }

    /**
     * Test fetching cart and travel data for a given email.
     *
     * @return void
     */
    #[Test]
    public function itFetchesCartTravelDataForUser(): void
    {
        /** @var Travel $travel */
        $travel = Travel::factory()->create();

        /** @var Cart $cart */
        $cart = Cart::factory()->create([
            'email' => 'user@example.com',
            'travel_id' => $travel->id,
            'status' => Cart::ACTIVE,
        ]);

        $cartModel = new Cart();
        $data = $cartModel->getCartTravelData('user@example.com');

        $this->assertNotEmpty($data);
        $this->assertSame($cart->id, $data->first()->id);
    }

    /**
     * Test checking if a cart is already present for a user.
     *
     * @return void
     */
    #[Test]
    public function itChecksIfCartAlreadyExists(): void
    {
        $travel = Travel::factory()->create();
        Cart::factory()->create([
            'email' => 'user@example.com',
            'travel_id' => $travel->id,
            'status' => Cart::ACTIVE,
        ]);

        $cartModel = new Cart();
        $this->assertTrue($cartModel->checkCartAlreadyPresent($travel->id, 'user@example.com'));
        $this->assertFalse($cartModel->checkCartAlreadyPresent($travel->id, 'other@example.com'));
    }

    /**
     * Test adding a cart with transactions.
     *
     * @return void
     */
    #[Test]
    public function itAddsACartWithTransactions(): void
    {
        $travel = Travel::factory()->create([
            'price' => 100,
            'reserved_seat_number' => 0,
        ]);

        $cartModel = new Cart();
        $cart = $cartModel->addEntities($travel, [
            'email' => 'user@example.com',
            'travel_id' => $travel->id,
            'reserved_seat' => 2,
        ]);

        $this->assertDatabaseHas('carts', ['id' => $cart->id, 'email' => 'user@example.com']);
        $this->assertSame(200, $cart->total_amount);
    }
}
