<?php declare(strict_types=1);

namespace App\Jobs;

use App\Models\Cart;
use App\Models\Travel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/**
 * Class ExpireCartJob.
 */
class ExpireCartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Delay time to run the business logic.
     *
     * @var int
     */
    public const DELAY = 15;

    /**
     * Instance variable.
     *
     * @var string
     */
    public string $cart_id;

    /**
     * Create the job.
     *
     * @param string $cart_id
     */
    public function __construct(string $cart_id)
    {
        $this->cart_id = $cart_id;
    }

    /**
     * Business logic to handle the cart expiration.
     *
     * @return void
     */
    public function handle(): void
    {
        DB::transaction(function (): void {
            /** @var Cart $cart */
            $cart = Cart::find($this->cart_id);

            if (!$cart || $cart->expiration_time > Carbon::now()) {
                return;
            }

            $cart->status = Cart::EXPIRED;
            $cart->save();

            /**
             * Use of pessimistic lock to avoid race condition.
             *
             * @var Travel $travel
             */
            $travel = Travel::where('id', $cart->travel_id)
                            ->lockForUpdate()
                            ->first();

            if ($travel) {
                $travel->reserved_seat_number = max(0, $travel->reserved_seat_number - $cart->reserved_seat);
                $travel->save();
            }
        });
    }
}
