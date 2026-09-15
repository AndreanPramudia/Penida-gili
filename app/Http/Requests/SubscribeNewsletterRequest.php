<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeNewsletterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc', 'max:190'],
            // Honeypot: real visitors never see this field, bots fill everything.
            'website' => ['prohibited'],
        ];
    }
}
