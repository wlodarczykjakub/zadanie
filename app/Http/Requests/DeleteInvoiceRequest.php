<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteInvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'numeric', 'exists:invoice,id'],
        ];
    }
}
