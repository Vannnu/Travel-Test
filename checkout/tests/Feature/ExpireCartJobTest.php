<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\ExpireCartJob;
use App\Models\Cart;
use App\Models\Travel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Class ExpireCartJobTest.
 */
class ExpireCartJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the ExpireCartJob process for cart expiration.
     *
     * @return void
     */
    #[Test]
    public function itExpiresTheCartWhenTimeIsUp(): void
    {
        $travel = Travel::factory()->create([
            'seat_capacity' => 50,
            'reserved_seat_number' => 5,
        ]);

        $cart = Cart::factory()->create([
            'travel_id' => $travel->id,
            'status' => Cart::ACTIVE,
            'expiration_time' => Carbon::now()->subMinute(),
            'reserved_seat' => 2,
        ]);

        $job = new ExpireCartJob($cart->id);
        $job->handle();

        $cart->refresh();
        $this->assertSame(Cart::EXPIRED, $cart->status);

        $travel->refresh();
        $this->assertSame(3, $travel->reserved_seat_number);
    }

    /**
     * Test that the ExpireCartJob does nothing when the cart has not expired yet.
     *
     * @return void
     */
    #[Test]
    public function itDoesNothingWhenCartHasNotExpired(): void
    {
        $travel = Travel::factory()->create([
            'seat_capacity' => 50,
            'reserved_seat_number' => 5,
        ]);

        $cart = Cart::factory()->create([
            'travel_id' => $travel->id,
            'status' => Cart::ACTIVE,
            'expiration_time' => Carbon::now()->addMinutes(10),
            'reserved_seat' => 2,
        ]);

        $job = new ExpireCartJob($cart->id);
        $job->handle();

        $cart->refresh();
        $this->assertSame(Cart::ACTIVE, $cart->status);

        $travel->refresh();
        $this->assertSame(5, $travel->reserved_seat_number);
    }

    /**
     * Test if the ExpireCartJob handles a non-existing cart correctly.
     *
     * @return void
     */
    #[Test]
    public function itDoesNothingIfCartDoesNotExist(): void
    {
        $job = new ExpireCartJob('non-existing-cart-id');
        $job->handle();

        $this->assertNull(Cart::find('non-existing-cart-id'));
    }
}
