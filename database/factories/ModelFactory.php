<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Http\Model\Link::class, function (Faker\Generator $faker) {
    return [
        'link_name' => $faker->text(10),
        'link_title' => $faker->text(20),
        'link_url' => $faker->url,
        'link_order' => $faker->numberBetween(0,20),
    ];
});

$factory->define(App\Http\Model\Nav::class, function (Faker\Generator $faker) {
    return [
        'nav_name' => $faker->text(10),
        'nav_alias' => $faker->text(10),
        'nav_url' => $faker->url,
        'nav_order' => $faker->numberBetween(0,10),
        'created_at'=>$faker->dateTimeThisYear,
    ];
});

$factory->define(App\Http\Model\Config::class, function (Faker\Generator $faker) {
    return [
        'conf_title' => $faker->word,
        'conf_name' => $faker->word,
        'filed_type' => $faker->randomElement($array = array ('input','textarea','radio')),
        'filed_value'=> $faker->randomElement($array = array ('0','1')),
        'conf_order' => $faker->numberBetween(0,10),
        'conf_tips' => $faker->sentence,
        'created_at'=>$faker->dateTimeThisYear,
    ];
});