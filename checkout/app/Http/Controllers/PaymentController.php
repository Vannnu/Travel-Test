<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;

/**
 * Class PaymentController.
 */
class PaymentController extends Controller
{
    /**
     * Instance variable.
     *
     * @var PaymentMethod
     */
    protected PaymentMethod $model;

    /**
     * Constructor function.
     *
     * @param PaymentMethod $payment
     */
    public function __construct(PaymentMethod $payment)
    {
        $this->model = $payment;
    }

    /**
     * Service to return all the active payment methods.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->model->where('is_active', 1)->get());
    }

    /**
     * Function to simulate a fake payment,.
     *
     * @param PaymentMethodRequest $request
     *
     * @return JsonResponse
     */
    public function pay(PaymentMethodRequest $request): JsonResponse
    {
        $this->getRequestBody($request);

        /** @var string $transactionId */
        $transactionId = $this->payload['payment_method_id'] .
            $this->payload['cart_id'] .
            $this->payload['total_amount'] . now();

        return response()->json(
            [
                'transaction_id' => sha1($transactionId),
                'total_amount' => $this->payload['total_amount'],
            ]
        );
    }
}
