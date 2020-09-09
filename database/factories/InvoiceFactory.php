<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'number' => $faker->unique()->numberBetween(1,1000),
        'nip_buyer' => $faker->numerify('##########'),
        'nip_seller' => $faker->numerify('##########'),
        'product_name' => strtoupper($faker->lexify('???')),
        'net_price' => $faker->randomFloat(2,1,1000),
    ];
});
