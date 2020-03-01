<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    //告知laravel 此模型不需要创建created_at updated_at
    public $timestamps = false;
}
