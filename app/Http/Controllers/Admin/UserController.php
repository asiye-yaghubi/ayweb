<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','desc')->get();
        $roles = Role::get();
        return view('admin.pages.user.user',compact('users','roles'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            // 'role_id' =>'required',
            'image' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
		]);
        $arr = array('status' => false);      
        if($validator->passes()){ 
            $password = Hash::make($request->password);
            if($request->status == true) {
                $status = 1;
            } else if($request->status == false) {
                $status = 0;
            }     
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$password,
                'status' => $status
                ]); 
            $u = $user->roles()->sync($request->input('role_id'));
            if($request['image']) {
                $file = $request->file('image');
                $path = 'users/';
                $image = $this->ImageUploader($file,$path);
                $photo = new Image;
                $photo->url = $image;
                $l = $user->images()->save($photo);
                $pic = ['path'=>$image];
            } else {
                $pic = ['path'=> 'admin/theme/images/user.png'];
            }
            
            if(!empty($user->roles->first())) {
                foreach($user->roles as $item) {
                    $select[] = $item->title;
                }
            }  
            else{
                $select[] = [0 => 'false'];
            }  
            
            $arr = array('status' => true);
            return response(["user"=>$user,"arr"=>$arr, "select" => $select, 'pic'=>$pic]);
        }
        return response(["arr"=>$arr,'errors'=>$validator->errors()->all()]);  
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $user = User::findOrFail($id);
            if(!empty($user->roles()->first())) {
                foreach($user->roles as $item) {
                    $select[] = $item->title;
                }
            } else{
                $select[] = [0 => 'false'];
            }  
            return response()->json(['user' => $user, 'select' => $select]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'role_id' =>'required',
            // 'status' =>'required',
        ]);  
       
        $arr = array('status' => false);      
        if($validator->passes()){ 
            $user = User::find($request->value_id);
            $user->roles()->sync($request->input('role_id'));
            if($request->status == true) {
                $user->status = 1;
            } else if($request->status == false) {
                $user->status = 0;
            }
            $user->save();
            if(!empty($user->roles->first())) {
                foreach($user->roles as $item) {
                    $select[] = $item->title;
                }
            }  
            else{
                $select[] = [0 => false];
            }  
            
            $arr = array('status' => true);
            return response(["user"=>$user,"arr"=>$arr, "select" => $select]);
        }
        return response(["arr"=>$arr,'errors'=>$validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!empty($user->images()->first()))
        {
            $photo = $user->images()->first();
            unlink($photo->url) or die('Delete Error');
            $photo->delete();    
        }
        $user = $user->delete();
        return response()->json($user);
    }
}
