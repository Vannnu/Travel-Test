<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Jobs\ExpireCartJob;
use App\Models\Cart;
use App\Models\Travel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class CartController.
 */
class CartController extends Controller
{
    /**
     * Instance variable.
     *
     * @var Cart
     */
    protected Cart $model;

    /**
     * Constructor function.
     *
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->model = $cart;
    }

    /**
     * Function to return all the carts.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $this->getRequestBody($request, false);

        if (empty($this->payload['email'])) {
            throw new BadRequestHttpException('Email Obbligatoria');
        }

        return response()->json($this->model->getCartTravelData($this->payload['email']));
    }

    /**
     * Function to create a cart (reserve seats).
     *
     * @param CartRequest $request
     *
     * @return JsonResponse
     */
    public function create(CartRequest $request): JsonResponse
    {
        $this->getRequestBody($request);

        /** @var Travel $travel */
        $travel = (new Travel())->find($this->payload['travel_id']);

        if ($this->model->checkCartAlreadyPresent($this->payload['travel_id'], $this->payload['email'])) {
            throw new BadRequestHttpException("Hai gia un cart attivo per il viaggio: {$travel->name}");
        }

        if ($travel->availability - $this->payload['reserved_seat'] >= 0) {
            /** @var Cart $cart */
            $cart = $this->model->addEntities($travel, $this->payload);

            // Schedule the job to run after 15 minutes and invalidate it.
            ExpireCartJob::dispatch($cart->id)->delay(now()->addMinutes(ExpireCartJob::DELAY));
        } else {
            throw new BadRequestHttpException('Non ci sono abbastanza posti disponibili');
        }

        return response()->json($cart->fresh());
    }
}
