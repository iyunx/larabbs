<?php
namespace App\Handlers;

use  Illuminate\Support\Str;

class ImageUploadHandler
{
    protected $allowed_ext = ['jpg', 'gif', 'jpeg', 'png'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        $folder_name = "uploads/images/$folder/" . date('Y/md', time());

        $upload_path = public_path().'/'.$folder_name;

        $extension = strtolower($file->getClientOriginalExtension())?:'png';

        $file_name = $file_prefix . '_' . time() . '_' . str::random(10) .'.'. $extension;

        if(!in_array($extension, $this->allowed_ext)){
            return false;
        }
        //注意这个在前
        $file->move($upload_path, $file_name);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path . '/' . $file_name, $max_width);
        }

        return [
            'path' => config('app.url')."/$folder_name/$file_name"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        $image = \Image::make($file_path);

        $image->resize($max_width, null, function($constraint){
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        $image->save();
    }
}