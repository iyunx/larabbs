<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category, Topic $topic, Request $request)
    {
        $topics = $topic->withOrder($request->order)->where('category_id', $category->id)->with('category', 'user')->paginate();
        return view('topics.index', compact('topics', 'category'));
    }
}
