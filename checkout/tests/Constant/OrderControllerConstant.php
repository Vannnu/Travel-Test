<?php declare(strict_types=1);

namespace Tests\Constant;

class OrderControllerConstant
{
    /**
     * Constant Used to test the CREATE api response structure.
     *
     * @var array
     */
    public const API_CREATE_RESPONSE = [
        'id',
        'cart_id',
        'total_amount',
        'payment_method_id',
        'created_at',
        'updated_at',
    ];
}
