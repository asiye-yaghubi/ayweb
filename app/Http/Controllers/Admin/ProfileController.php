<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.pages.profile.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $user = Auth::user();
            // if($user->images()) 
            // {
            //     $pic = ['path'=>$user->images()->first()->url];
            // }
 
            // return response()->json(['pic' => $pic]);
            return response()->json();

        }
    }

    public function changeImage(Request $request) {
       
        $auth = auth()->user();
        $user = User::find($auth->id);
        $file = $request->image;
        $image = $this->ImageCropUpload($file);     

        if($user->images()->first()) {
            $photo = $user->images()->first();
            unlink($photo->url) or die('Delete Error');
            $photo->url = $image;
            $photo->update();
        } else {
            $photo = new Image();
            $photo->url = $image;
            $user->images()->save($photo);
        }
         
        return response()->json(['status'=>true]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
