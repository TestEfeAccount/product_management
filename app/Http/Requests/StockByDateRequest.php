<?php

namespace App\Http\Requests;

use App\Trait\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class StockByDateRequest extends FormRequest
{

    use FailedValidationTrait;


    /**
     * Determine if the user is authorized to make this request.
     */
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
            'date' => ['required', 'date_format:Y-m-d'],
        ];
    }

    /**
     * @return array|null
     */
    public function validationData(): ?array
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
