<?php

namespace App\Http\Requests;

use App\Trait\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     return  [
            'clientId'=>'required|integer|exists:clients,id',
            'products'       => 'required|array|min:1',
            'products.*.id'  => 'required|integer|exists:products,id',
            'products.*.qty' => 'required|integer|min:1'];
    }
}
