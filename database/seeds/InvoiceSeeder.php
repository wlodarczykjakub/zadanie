<?php

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{

    public function run()
    {
        factory(Invoice::class, 50)->create();
    }
}
