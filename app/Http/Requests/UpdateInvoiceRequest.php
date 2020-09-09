<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'numeric', 'exists:invoice,id'],
            'number' => ['numeric', 'min:1', 'max:10000'],
            'nip_buyer' => ['required', 'string', 'min:10', 'max:10'],
            'nip_seller' => ['required', 'string', 'min:10', 'max:10'],
            'product_name' => ['string', 'min:1', 'max:250'],
            'net_price' => ['numeric', 'min:0.01', 'max:99999.99'],
        ];
    }
}
