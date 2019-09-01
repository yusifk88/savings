<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'title' =>$faker->title,
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'sex' => 'Male',
        'hometown' =>$faker->city,
        'dob' => $faker->date(),
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'bank' =>'Ghana Commercial Bank',
        'accno' => $faker->bankAccountNumber,
        'occupation' => 'teacher',
        'passport' =>'',
        'email' =>$faker->safeEmail
    ];
});
