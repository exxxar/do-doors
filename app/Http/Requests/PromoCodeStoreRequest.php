<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:255', 'unique:promo_codes,code'],
            'discount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'end_at' => ['nullable'],
            'is_active' => ['required'],
        ];
    }
}
