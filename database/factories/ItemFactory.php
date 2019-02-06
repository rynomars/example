<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Item::class, function (Faker $faker) {
    return [
        //
        "part_number" => str_random(12),
        "brand_id"  => str_random(4),
        "status" => \App\Models\Item::STATUS_DRAFT
    ];
});
