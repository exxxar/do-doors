<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            'status' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:255'],
            'fax' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'fact_address' => ['nullable', 'string', 'max:255'],
            'fact_address_comment' => ['nullable', 'string'],
            'comment' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:255'],
            'external_code' => ['nullable', 'string', 'max:255'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'law_address' => ['nullable', 'string', 'max:255'],
            'inn' => ['nullable', 'string', 'max:20'],
            'kpp' => ['nullable', 'string', 'max:50'],
            'ogrn' => ['nullable', 'string', 'max:50'],
            'okpo' => ['nullable', 'string', 'max:50'],
            'requisites' => ['nullable', 'json'],
        ];
    }
}
