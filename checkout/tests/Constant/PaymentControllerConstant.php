<?php declare(strict_types=1);

namespace Tests\Constant;

class PaymentControllerConstant
{
    /**
     * Structure used in the test to verify INDEX correct response.
     *
     * @var array
     */
    public const API_INDEX_RESPONSE = [
        '*' => [
            'id',
            'name',
            'description',
            'is_active',
        ],
    ];

    /**
     * Structure used in the test to verify PAY correct response.
     *
     * @var array
     */
    public const API_PAY_RESPONSE = [
        'transaction_id',
        'total_amount',
    ];
}
