<?php

slugspace App\Http\Controllers\Admin;

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
        $roles = Role::orderBy('id','desc')->paginate(5);
        $permissions = Permission::get();
        return view('admin.role.role',compact('roles','permissions'));
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
            'slug' => 'required|string',
            'title' => 'required',
            'permission_id' => 'required',
		]);
       

        $arr = array('msg' => 'خطا!', 'status' => false);      
        if($validator->passes()){ 

            $role = Role::updateOrCreate(
            ['id' => $request->value_id],
            ['slug'=>$request->slug,'title'=>$request->title]
        );  
        $role->permissions()->sync($request->input('permission_id'));
        $permissions = $role->permissions;
        $arr = array('msg' => 'باموفقیت انجام شد!', 'status' => true);
        return response(["role"=>$role,"arr"=>$arr,'permissions'=>$permissions]);
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
        $role  = Role::where($where)->first();
        $select[] = $role->permissions()->pluck('id');

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
