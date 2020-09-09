<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'number' => ['required', 'numeric', 'min:1', 'max:10000'],
            'nip_buyer' => ['required', 'string', 'min:10', 'max:10'],
            'nip_seller' => ['required', 'string', 'min:10', 'max:10'],
            'product_name' => ['required', 'string', 'min:1', 'max:250'],
            'net_price' => ['required', 'numeric', 'min:0.01', 'max:99999.99'],
        ];
    }
}
