<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    // sentence()随机生成小段落字段
    // text() 随机生成大段落字段 
    $sentence = $faker->sentence();
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title'=>$sentence,
        'body'=>$faker->text(),
        'excerpt'=>$sentence,
        'created_at'=>$created_at,
        'updated_at'=>$updated_at,
    ];
});
