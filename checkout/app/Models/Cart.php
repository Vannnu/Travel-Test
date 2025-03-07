<?php declare(strict_types=1);

namespace App\Models;

use App\Jobs\ExpireCartJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Cart Class.
 *
 * @property string $id
 * @property string $email
 * @property string $travel_id
 * @property int $reserved_seat
 * @property $expiration_time
 * @property int $status
 * @property int $total_amount
 */
class Cart extends BaseModel
{
    use HasFactory;

    /**
     * Define the expiration status for the cart.
     */
    public const ACTIVE = 1;

    /**
     * Define the expiration status for the cart.
     */
    public const EXPIRED = 0;

    /**
     * Define the purchased status for the cart.
     */
    public const PURCHASED = 2;

    /**
     * {@inheritDoc}
     */
    protected $table = 'carts';

    /**
     * {@inheritDoc}
     */
    protected $primaryKey = 'id';

    /**
     * {@inheritDoc}
     */
    protected $keyType = 'string';

    /**
     * {@inheritDoc}
     */
    public $incrementing = false;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'email',
        'travel_id',
        'reserved_seat',
    ];

    /**
     * Relation with Travel.
     *
     * @return BelongsTo
     */
    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }

    /**
     * Function to fetch cart and travel data.
     *
     * @param string $email
     *
     * @return Collection
     */
    public function getCartTravelData(string $email): Collection
    {
        $travel = new Travel();
        /** @var string $cartTable */
        $cartTable = $this->getTable();

        /** @var string $travelTable */
        $travelTable = $travel->getTable();

        return self::join($travelTable, "{$cartTable}.travel_id", '=', "{$travelTable}.id")
                   ->where("{$cartTable}.status", self::ACTIVE)
                   ->where("{$cartTable}.email", $email)
                   ->select([
                       "{$cartTable}.id",
                       "{$cartTable}.reserved_seat",
                       "{$cartTable}.total_amount",
                       "{$cartTable}.email",
                       "{$travelTable}.name",
                       "{$travelTable}.starting_date",
                       "{$travelTable}.ending_date",
                       DB::raw("JSON_UNQUOTE(JSON_EXTRACT({$travelTable}.url_images, '$[0]')) AS url_images"), // Estrai la prima immagine
                       "{$travelTable}.departure_location",
                   ])
                   ->get();
    }

    /**
     * Check if a cart is already and active for the same user email.
     *
     * @param string $travel_id
     * @param string $email
     *
     * @return bool
     */
    public function checkCartAlreadyPresent(string $travel_id, string $email): bool
    {
        $is_present = true;

        /** @var Cart|null $prevCart */
        $prevCart = Cart::where('travel_id', $travel_id)
                        ->where('status', Cart::ACTIVE)
                        ->where('email', $email)
                        ->first();

        if (!$prevCart) {
            $is_present = false;
        }

        return $is_present;
    }

    /**
     * Handle the transactions to save cart and update reserved seat capacity.
     *
     * @param Travel $travel
     * @param array $data
     *
     * @return Cart
     */
    public function addEntities(Travel $travel, array $data): Cart
    {
        $cart = new self();

        DB::transaction(function () use ($cart, $travel, $data): void {
            $cart->expiration_time = now()->addMinutes(ExpireCartJob::DELAY);
            $cart->total_amount = $data['reserved_seat'] * $travel->price;
            $travel->reserved_seat_number += $data['reserved_seat'];
            if ($travel->availability === 0) {
                $travel->is_active = 0;
            }

            $cart->fill($data)
                 ->save();

            $travel->save();
        });

        return $cart;
    }
}
