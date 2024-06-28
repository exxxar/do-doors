<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpeningVariantUpdateRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:255'],
            'order_position' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'depth' => ['required', 'numeric'],
            'direction' => ['nullable', 'string', 'max:10'],
        ];
    }
}
