<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];

        // Add fields for vendors
        if ($this->user()->role === 'vendor') {
            $rules['shop_name'] = ['nullable', 'string', 'max:255'];
            $rules['address'] = ['nullable', 'string'];
        }

        // Add WhatsApp number for both vendors and recipients
        if (in_array($this->user()->role, ['vendor', 'recipient'])) {
            $rules['whatsapp_number'] = ['nullable', 'string', 'max:20'];
        }

        return $rules;
    }
}
