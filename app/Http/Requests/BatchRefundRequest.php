<?php

namespace App\Http\Requests;


use App\Trait\FailedValidationTrait;
use Illuminate\Contracts\Validation\ValidationRule;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\DB;

class BatchRefundRequest extends FormRequest
{
    use FailedValidationTrait;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'batch_id' => [
                'required',
                'exists:batches,id',
                function ($attribute, $value, $fail) {
                    $exists = DB::table('batch_products')
                        ->where('product_id', request('product_id'))
                        ->where('batch_id', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('Provided batch product combination does not exist.');
                    }
                }
            ],
            "quantity" => [
                'required', 'integer', 'min:1'],

        ];
    }


}
