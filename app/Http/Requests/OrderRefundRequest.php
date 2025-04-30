<?php

namespace App\Http\Requests;

use App\Rules\IsProductInStockForRefund;
use App\Trait\FailedValidationTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class OrderRefundRequest  extends FormRequest
{
    use FailedValidationTrait;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => [
                'required',
                'exists:orders,id',
            ],
            'order_item_id' => [
                'required',
                'exists:order_items,id',
            ],
            'client_id' => [
                'required',
                'exists:clients,id',
            ],
            "quantity" => [
                'required','integer','min:1'],

        ];
    }


}
