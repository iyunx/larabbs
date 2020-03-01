<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //获取所有用户的id, 组合成数组
        $user_idr = User::all()->pluck('id')->toArray();

        //获取所有分类id, 组合成数组
        $category_idr = Category::all()->pluck('id')->toArray();

        //获取faker实例
        $faker = app(Faker\Generator::class);


        $topics = factory(Topic::class)->times(100)->make()->each(function ($topic, $index) use($user_idr, $category_idr, $faker) {
            $topic->user_id = $faker->randomElement($user_idr);
            $topic->category_id = $faker->randomElement($category_idr);
        });

        Topic::insert($topics->toArray());
    }
}
