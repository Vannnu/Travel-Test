<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * Mood Order Class.
 *
 * @property string $id
 * @property string $cart_id
 * @property string payment_method_id
 * @property string transaction_id
 * @property int $status
 * @property int $total_amount
 */
class Order extends BaseModel
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $table = 'orders';

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
        'cart_id',
        'transaction_id',
        'payment_method_id',
        'status',
        'total_amount',
    ];

    /**
     * Relation with Cart.
     *
     * @return BelongsTo
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    /**
     * Relation with PaymentMethod.
     *
     * @return BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    /**
     * Function to create an order and update the related cart (atomic).
     *
     * @param Cart $cart
     * @param array $data
     *
     * @return void
     */
    public function orderPersist(Cart $cart, array $data): void
    {
        DB::transaction(function () use ($cart, $data): void {
            $cart->status = Cart::PURCHASED;
            $cart->save();

            self::fill($data)
                ->save();
        });
    }
}
