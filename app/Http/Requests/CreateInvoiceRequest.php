<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'number' => ['required', 'numeric', 'min:1', 'max:10000'],
            'nip_buyer' => ['required', 'numeric', 'min:1000000000', 'max:9999999999'],
            'nip_seller' => ['required', 'numeric', 'min:1000000000', 'max:9999999999'],
            'product_name' => ['required', 'string', 'min:1', 'max:250'],
            'net_price' => ['required', 'numeric', 'min:0.01', 'max:99999.99'],
            'create_date' => ['required', 'date'],
            'edit_date' => ['required', 'date'],
        ];
    }
}
