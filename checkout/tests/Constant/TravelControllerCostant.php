<?php declare(strict_types=1);

namespace Tests\Constant;

class TravelControllerCostant
{
    /**
     * Structure used in the test to verify INDEX correct response.
     *
     * @var array
     */
    public const API_INDEX_RESPONSE = [
        'data' => [
            '*' => self::API_BASE_STRUCTURE_RESPONSE,
        ],
        'links' => [
            'first',
            'last',
            'prev',
            'next',
        ],
        'meta' => [
            'current_page',
            'from',
            'last_page',
            'per_page',
            'to',
            'total',
        ],
    ];

    /**
     * Response Base structure used for INDEX and SHOW UTs.
     *
     * @var array
     */
    public const API_BASE_STRUCTURE_RESPONSE = [
        'id',
        'name',
        'location',
        'price',
        'created_at',
        'updated_at',
    ];
}
