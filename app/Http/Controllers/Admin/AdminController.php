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
        $databasename = 'uploads/'.$path;
        $mainpath = public_path($databasename);
        $file->move($mainpath,$filename);
        return $databasename.$filename;  
    }
}
