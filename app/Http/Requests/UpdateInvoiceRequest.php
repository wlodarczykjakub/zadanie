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
            'nip_buyer' => ['numeric', 'min:1000000000', 'max:9999999999'],
            'nip_seller' => ['numeric', 'min:1000000000', 'max:9999999999'],
            'product_name' => ['string', 'min:1', 'max:250'],
            'net_price' => ['numeric', 'min:0.01', 'max:99999.99'],
            'create_date' => ['date'],
            'edit_date' => ['date'],
        ];
    }
}
