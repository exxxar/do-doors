<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDetailUpdateRequest extends FormRequest
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
            'order_id' => ['nullable', 'integer', 'exists:orders,id'],
            'door_type' => ['nullable', 'string', 'max:255'],
            'count' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'comment' => ['nullable', 'string'],
            'purpose' => ['nullable', 'string'],
            'door' => ['nullable', 'json'],
        ];
    }
}
