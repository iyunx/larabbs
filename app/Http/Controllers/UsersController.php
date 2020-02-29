<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler; //自定义的图片上传
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UserRequest $request, ImageUploadHandler $uploader)
    {
        //权限策略，只能自己改自己的资料
        $this->authorize('update', $user);

        $data = $request->all();

        if($request->avatar){
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if($result) $data['avatar'] = $result['path'];
        }

        $user->update($data);
        return redirect()->route('users.show', $user)->with('success', '个人资料更新成功');
    }
}
