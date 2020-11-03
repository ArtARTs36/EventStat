<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use ArtARTs36\EventStat\Models\Type;
use Faker\Generator as Faker;

$factory->define(Type::class, function (Faker $faker) {
    return [
        Type::FIELD_SLUG => $faker->slug,
        Type::FIELD_TITLE => $faker->words(3, true),
    ];
});
