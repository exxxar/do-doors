<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'contract_number' => ['nullable', 'string', 'max:255'],
            'contract_date' => ['nullable'],
            'completion_at' => ['nullable'],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'status' => ['required', 'integer'],
            'source' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'organizational_form' => ['nullable', 'string', 'max:255'],
            'contract_amount' => ['required', 'numeric'],
            'paid' => ['required', 'numeric'],
            'debt' => ['required', 'numeric'],
            'profit' => ['required', 'numeric'],
        ];
    }
}
