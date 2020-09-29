<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Icon;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::where('parent_id', 0)->orderBy('id','desc')->get();
        $tags = Tag::get();
        $icons = Icon::get();
        return view('admin.pages.category.category',compact('categorys','tags', 'icons'));
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
            'title' => 'required',
            'slug' => 'required|string|unique:categories,slug',
            'tag_id' => 'required',
            'icon_id' => 'required',
            // 'status' =>'required',
            'parent_id' =>'required',
            'image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
		]);
        $arr = array('status' => false);      
        if($validator->passes()){ 
            
            if($request->status == true) {
                $status = 1;
            } else if($request->status == false) {
                $status = 0;
            }     
            $category = Category::create([
                'title'=>$request->title,
                'slug'=>$request->slug,
                'parent_id'=>$request->parent_id,
                'status' => $status,
                'icon_id'=>$request->icon_id,
                ]); 
            $category->tag()->sync($request->input('tag_id'));
            if($request['image']) {
                $file = $request->file('image');
                $path = 'categories/';
                $image = $this->ImageUploader($file,$path);
                $photo = new Image();
                $photo->url = $image;
                $l = $category->images()->save($photo);
                $pic = ['path'=>$image];
            } 
            
            if(!empty($category->childs->first())) {
                $childs = $category->childs;
            }  
            else{
                $childs = [0 => 'false'];
            } 
            if(!empty($category->tag->first())) {
                foreach($category->tag as $item) {
                    $tags[] = $item->title;
                }
            }  
        
            $icon = $category->icon;
            $arr = array('status' => true);
            if($category->parent_id != 0 ) {
                $category = [0 => 'false'];
            }
            return response(["category"=>$category,"arr"=>$arr, "tags" => $tags, 'pic'=>$pic, 'icon' => $icon, 'childs' => $childs]);
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
            $category = Category::findOrFail($id);
            $pic = ['path'=>$category->images()->first()->url];
            $icon = $category->icon;
            if($category->parent_id == 0) {
                $parent = [0 => 'leader']; 
            } else {
                $parent = Category::find($category->parent_id);
            }

            foreach($category->tag as $item) {
                $tags[] = $item->title;
            }
 
            return response()->json(['category' => $category, 'tags' => $tags, 'icon' => $icon, 'pic' => $pic, 'parent' => $parent]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|string',
            'tag_id' => 'required',
            'icon_id' => 'required',
            // 'status' =>'required',
            'parent_id' =>'required',
            'image' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
		]);
        $arr = array('status' => false);      
        $category = Category::find($request->value_id);

        if($validator->passes()){ 
            
            if($request->status == true) {
                $status = 1;
            } else if($request->status == false) {
                $status = 0;
            }     
            
            $category->title = $request->title;
            $category->slug = $request->slug;
            $category->parent_id = $request->parent_id;
            $category->status = $status;
            $category->icon_id = $request->icon_id;
            $category->update();

            $category->tag()->sync($request->input('tag_id'));
            if($request['image']) {
                $file = $request->file('image');
                $path = 'categories/';
                $image = $this->ImageUploader($file,$path);
                $photo = $category->images()->first();
                $photo->url = $image;
                $photo->update();
                $pic = ['path'=>$image];
            } else {
                $pic = ['path'=>$category->images()->first()->url];
            }
            
            if(!empty($category->childs->first())) {
                $childs = $category->childs;
            }  
            else{
                $childs = [0 => 'false'];
            } 
            if(!empty($category->tag->first())) {
                foreach($category->tag as $item) {
                    $tags[] = $item->title;
                }
            }  
        
            $icon = $category->icon;
            $arr = array('status' => true);
            if($category->parent_id != 0 ) {
                $category = [0 => 'false'];
            }
            return response(["category"=>$category,"arr"=>$arr, "tags" => $tags, 'pic'=>$pic, 'icon' => $icon, 'childs' => $childs]);
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
        $category = Category::find($id);
        $childs = $category->childs;
        if(count($childs) > 0) {
            $status = [0 => "error"];
            return response()->json(['status' => $status]);
            
           
        } 
        else {
            if(!empty($category->images()->first()))
            {
                $photo = $category->images()->first();
                unlink($photo->url) or die('Delete Error');
                $photo->delete();    
            }
            $category = $category->delete();
            return response()->json($category);
        }

    }
}
