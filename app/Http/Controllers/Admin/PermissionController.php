<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// use Validator,Redirect,Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::orderBy('id','desc')->get();
        return view('admin.pages.permission.permission',compact('permissions'));
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
            'slug' => 'required|alpha_dash|max:255|unique:permissions,slug',
            'title' => 'required|string',
		]);
      
        $arr = array('status' => false);      
        if($validator->passes()){ 

            $permission = Permission::updateOrCreate(
            ['id' => $request->value_id],
            ['slug'=>$request->slug,'title'=>$request->title]
        );     
        $arr = array('msg' => 'باموفقیت انجام شد!', 'status' => true);
        return response(["permission"=>$permission,"arr"=>$arr]);
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
        $where = array('id' => $id);
        $permission  = Permission::where($where)->first();
        return response()->json($permission);
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
        $permission = Permission::where('id',$id)->delete();
        return response()->json($permission);
    }
}
