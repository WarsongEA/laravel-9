<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'emails' => 'required|array',
            'emails.*.messageBody' => 'required|string',
            'emails.*.messageSubject' => 'required|string',
            'emails.*.toEmailAddress' => 'required|email',
        ];
    }
}
