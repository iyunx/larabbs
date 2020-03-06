<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SyncUserActivedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:sync-user-actived-at';

    /**
     * The console command description.
     * 描述
     * @var string
     */
    protected $description = '将用户最后登录时间从Redis 同步到数据库中';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        //这里是User模型trait的lastactivedathelper中的方法
        //也是自定义的方法，此trait
        $user->syncUserActivedAt();
        $this->info('同步成功！');
    }
}
