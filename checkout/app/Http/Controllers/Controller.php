<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class Controller
{
    /**
     * Payload instance variable.
     *
     * @var array
     */
    public array $payload = [];

    /**
     * Extract all the data from a request.
     *
     * @param Request $request
     * @param bool $body
     *
     * @return $this
     */
    protected function getRequestBody(Request $request, bool $body = true): self
    {
        if ($body) {
            /** @var ParameterBag|null $payload */
            $payload = $request->json();

            if ($payload) {
                $payload = $payload->all();
            }
        } else {
            $payload = $request->query();
        }

        if (is_array($payload)) {
            $this->payload = Arr::dot(array_merge($payload, $this->payload));
        }

        return $this;
    }
}
