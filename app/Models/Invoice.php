<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $table = 'invoice';

    public $fillable = [
        'number',
        'nip_buyer',
        'nip_seller',
        'product_name',
        'net_price',
    ];
}
