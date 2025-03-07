<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class OrderController.
 */
class OrderController extends Controller
{
    /**
     * Order instance variable.
     *
     * @var Order
     */
    protected Order $model;

    /**
     * Constructor function.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * Function to create the Order.
     *
     * @param OrderRequest $request
     *
     * @return JsonResponse
     */
    public function create(OrderRequest $request): JsonResponse
    {
        /**
         * Variable to handle the payment confirmation.
         *
         * $payment = new PaymentAdapter($this->payload['payment_method_id']);
         */
        $this->getRequestBody($request);

        $cart = Cart::find($this->payload['cart_id']);

        if ($cart->status === Cart::EXPIRED) {
            /**
             * Handle the refund/remove preapproval with a call.
             * here we could create an Adapter to handle the different payment integrations.
             * refundPayment simulate the refund of the money.
             *
             * $payment->refundPayment($this->payload);
             */
            throw new BadRequestHttpException('Il tuo carrello è Expired. Non hai più posti riservati');
        }

        try {
            $this->model->orderPersist($cart, $this->payload);
            /**
             * Handle the confirmation of the preapproval with a call.
             * here we could create an Adapter to handle the different payment integrations.
             * confirmPayment simulate the preapproval confirmation.
             *
             * $payment->confirmPayment($this->payload);
             */
        } catch (Exception) {
            /**
             * Handle the refund/remove preapproval with a call.
             * here we could create an Adapter to handle the different payment integrations.
             * refundPayment simulate the refund of the money.
             *
             * $payment->refundPayment($this->payload);
             */
            throw new BadRequestHttpException('Qualcosa è andato storto!');
        }

        return response()->json($this->model->fresh());
    }
}
