<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function ImageUploader($file,$path)
    {
        $mime = $file->getClientOriginalExtension();
        $filename = time().'.'.$mime;
        $databasename = 'img/uploads/'.$path;
        $mainpath = public_path($databasename);
        $file->move($mainpath,$filename);
        return $databasename.$filename;  
    }

    public function ImageCropUpload($file)
    {
        list($type, $file) = explode(';', $file);
        list(, $file)      = explode(',', $file);
        $file = base64_decode($file);
        $image_name= time().'_'.rand(100,999).'.png';
        $databasename = 'uploads/'.$image_name;

        $path = public_path($databasename);
        file_put_contents($path, $file);
        return $databasename;  

    }
}
