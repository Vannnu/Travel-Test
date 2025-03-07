<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Mood TravelMood Class.
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property bool $is_active
 * @property $created_at
 * @property $updated_at
 */
class PaymentMethod extends BaseModel
{
    use HasFactory;

    /**
     * Define the status for the payment method.
     */
    public const ACTIVE = 1;

    /**
     * Define the status for the payment method.
     */
    public const NOT_ACTIVE = 0;

    /**
     * {@inheritDoc}
     */
    protected $table = 'payment_methods';

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
    public $timestamps = false;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * Relation with Order.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'payment_method_id');
    }
}
