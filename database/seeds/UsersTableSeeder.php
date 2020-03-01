<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获取faker实例
        $faker = app(Faker\Generator::class);

         // 头像假数据
         $avatars = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        //生成数据集合
        $users = factory(User::class)->times(10)->make()->each(function ($user, $index) use ($faker, $avatars){
            // 从头像数组中随机取出一个并赋值
            $user->avatar = $faker->randomElement($avatars);
        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        //插入到数据库中
        User::insert($user_array);

        $user = User::find(1);
        $user->name = 'admin';
        $user->email = 'iyunx@qq.com';
        $user->password = bcrypt('123456');
        $user->avatar = 'http://66.cc/uploads/images/avatars/2020/0229/1_1582986562_EHlOd3jtCr.jpg';
        $user->save();
    }
}
