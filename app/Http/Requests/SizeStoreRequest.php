<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeStoreRequest extends FormRequest
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
            'width' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'material_id' => ['required', 'integer', 'exists:materials,id'],
            'price' => ['required', 'numeric'],
            'price_koef' => ['required', 'numeric'],
            'loops_count' => ['required', 'integer'],
        ];
    }
}
