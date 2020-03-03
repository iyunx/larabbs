<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //notifications() 是 user模型中use Notifiable中的方法
        // 当前登录用户的所有通知
        $notifications = Auth::user()->notifications()->paginate();

        //标记为已读，未读数量清零 markAsRead是user模型中方法
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
