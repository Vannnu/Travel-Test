<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Travel Model Class.
 *
 * @property string $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $moods
 * @property string $starting_date
 * @property string $ending_date
 * @property float $price
 * @property int $original_seat_capacity
 * @property int $seat_capacity
 * @property int $reserved_seat_number
 * @property int $availability
 * @property string $url_images // '[<main_image>, <second> .... ]'
 * @property string $departure_location
 * @property int $duration
 * @property int $is_active
 */
class Travel extends BaseModel
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $table = 'travels';

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
    public $timestamps = true;

    /**
     * {@inheritDoc}
     */
    public $incrementing = false;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'moods',
        'starting_date',
        'ending_date',
        'price',
        'original_seat_capacity',
        'seat_capacity',
        'reserved_seat_number',
        'url_images',
        'departure_location',
        'is_active',
    ];

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'moods' => 'array',
        'description' => 'array',
        'url_images' => 'array',
    ];

    /**
     * Relation with Cart.
     *
     * @return HasMany
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'travel_id');
    }

    /**
     * Accessor for the availability (calculated field).
     *
     * @return int
     */
    public function getAvailabilityAttribute(): int
    {
        return $this->seat_capacity - $this->reserved_seat_number;
    }

    /**
     * Accessor for the duration (calculated field).
     *
     * @return int
     */
    public function getDurationAttribute(): int
    {
        $startingDate = Carbon::parse($this->starting_date);
        $endingDate = Carbon::parse($this->ending_date);

        return (int) $startingDate->diffInDays($endingDate);
    }

    /**
     * Fetch the Travels.
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function scopeSearchQuery(array $filters): LengthAwarePaginator
    {
        $query = self::where('is_active', 1)
                     ->where('starting_date', '>', now())
                     ->whereRaw('seat_capacity - reserved_seat_number > 0');

        if (!empty($filters['q.name'])) {
            $query->where('name', 'LIKE', "%{$filters['q.name']}%");
        }

        if (!empty($filters['q.price_min']) && !empty($filters['q.price_max'])) {
            $query->whereBetween('price', [$filters['q.price_min'], $filters['q.price_max']]);
        }

        if (!empty($filters['q.starting_date'])) {
            $query->whereDate('starting_date', '>=', $filters['q.starting_date']);
        }

        if (!empty($filters['q.duration'])) {
            $query->havingRaw('DATEDIFF(ending_date, starting_date) = ?', [$filters['q.duration']]);
        }

        if (!empty($filters['q.seat_capacity'])) {
            $query->whereRaw('seat_capacity - reserved_seat_number >= ?', [$filters['q.seat_capacity']]);
        }

        $query->orderBy($filters['q.sort'] ?? 'id', $filters['q.order'] ?? 'DESC');

        $travels = $query->paginate($filters['q.take'] ?? 50);

        return $this->decodeData($travels);
    }

    /**
     * Transform data to be inserted inside the Db.
     *
     * @param $travels
     *
     * @return mixed
     */
    public function decodeData($travels): mixed
    {
        $travels->map(function ($travel) {
            $travel->moods = json_decode($travel->moods, true);
            $travel->description = json_decode($travel->description, true);
            $travel->url_images = json_decode($travel->url_images, true);

            return $travel;
        });

        return $travels;
    }
}
