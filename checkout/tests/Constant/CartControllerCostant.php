<?php declare(strict_types=1);

namespace Tests\Constant;

/**
 * Class CartControllerCostant.
 */
class CartControllerCostant
{
    /**
     * Expected structure INDEX of the response.
     *
     * @var array
     */
    public const API_INDEX_RESPONSE_STRUCTURE = [
        '*' => [
            'id',
            'reserved_seat',
            'total_amount',
            'email',
            'name',
            'url_images',
        ],
    ];

    /**
     * Expected structure of the CREATE response.
     *
     * @var array
     */
    public const API_CREATE_RESPONSE_STRUCTURE = [
        'id',
        'email',
        'travel_id',
        'reserved_seat',
        'created_at',
        'updated_at',
    ];
}
