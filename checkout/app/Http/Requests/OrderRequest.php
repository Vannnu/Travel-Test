<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class OrderRequest.
 */
class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cart_id' => 'required|string|exists:carts,id',
            'transaction_id' => 'required|string',
            'payment_method_id' => 'required|string|exists:payment_methods,id',
            'total_amount' => 'required|numeric',
        ];
    }
}
