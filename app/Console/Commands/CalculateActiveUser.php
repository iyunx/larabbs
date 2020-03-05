<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     * 供我们调用的类
     * @var string
     */
    protected $signature = 'larabbs:calculate-active-user';

    /**
     * The console command description.
     * 命令描述
     * @var string
     */
    protected $description = '生成活跃用户';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        $this->info('开始计算...');

        $user->setActiveUsers();

        $this->info("成功生成！");
    }
}
