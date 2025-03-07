<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class TravelController.
 */
class TravelController extends Controller
{
    /**
     * Instance variable.
     *
     * @var Travel
     */
    protected Travel $model;

    /**
     * Constructor function.
     *
     * @param Travel $travel
     */
    public function __construct(Travel $travel)
    {
        $this->model = $travel;
    }

    /**
     * Function to search records in the DB, taking care of the search parameters.
     *
     * @param Request $request
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $this->getRequestBody($request, false);

        return $this->model->scopeSearchQuery($this->payload);
    }

    /**
     * Function to fetch travel record from the DB.
     *
     * @param string $uuid
     *
     * @throws  ModelNotFoundException
     *
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $travel = $this->model->findOrFail($uuid);

        $travel = $this->model->decodeData(collect([$travel]));

        return response()->json($travel->first());
    }
}
