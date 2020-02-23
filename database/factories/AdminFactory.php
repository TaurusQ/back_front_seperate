<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Admin::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'password' => bcrypt('123456'),
    ];
});
