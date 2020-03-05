<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category, Topic $topic, Request $request, User $user, Link $link)
    {
        $topics = $topic->withOrder($request->order)->where('category_id', $category->id)->with('category', 'user')->paginate();
        
        $active_users = $user->getActiveUsers();
        // 资源链接
        $links = $link->getAllCached();
        return view('topics.index', compact('topics', 'category', 'active_users', 'links'));
    }
}
