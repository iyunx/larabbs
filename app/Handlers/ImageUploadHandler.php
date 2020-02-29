<?php
namespace App\Handlers;

use  Illuminate\Support\Str;

class ImageUploadHandler
{
    protected $allowed_ext = ['jpg', 'gif', 'jpeg', 'png'];

    public function save($file, $folder, $file_prefix)
    {
        $folder_name = "uploads/images/$folder/" . date('Y/md', time());

        $upload_path = public_path().'/'.$folder_name;

        $extension = strtolower($file->getClientOriginalExtension())?:'png';

        $file_name = $file_prefix . '_' . time() . '_' . str::random(10) .'.'. $extension;

        if(!in_array($extension, $this->allowed_ext)){
            return false;
        }

        $file->move($upload_path, $file_name);

        return [
            'path' => config('app.url')."/$folder_name/$file_name"
        ];
    }
}