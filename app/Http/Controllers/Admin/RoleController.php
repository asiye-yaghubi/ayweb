<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id','desc')->get();
        $permissions = Permission::get();
        return view('admin.pages.role.role',compact('roles','permissions'));
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
        // dd($request);
        $validator = Validator::make($request->all(), [
            // 'slug' => 'required|alpha_dash|max:255|unique:roles,slug',
            'slug' => 'required|alpha_dash|max:255',
            'title' => 'required|string',
            'permission_id' => 'required',
		]);
      
        $arr = array('status' => false);      
        if($validator->passes()){ 

            $role = Role::updateOrCreate(
            ['id' => $request->value_id],
            ['slug'=>$request->slug,'title'=>$request->title]
        );     
        $role->permissions()->sync($request->input('permission_id'));

        $arr = array('status' => true);
        return response(["role"=>$role,"arr"=>$arr]);
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
        // dd('kk');
        $where = array('id' => $id);
        $role  = Role::where($where)->first();
        if(count($role->permissions)) {
            foreach($role->permissions as $item) {
                $select[] = $item->title;
            }
        }  
        else{
            $select[] = [0 => 'false'];
        }  
        // dd($select); 
        
        return response()->json(['role'=>$role,'select'=>$select]);
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
        $role = Role::where('id',$id)->delete();
        return response()->json($role);
    }
}
