<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id','desc')->get();
        $tags = Tag::get();
        $categorys = Category::get();
        return view('admin.pages.post.post',compact('posts','tags', 'categorys'));
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
            'slug' => 'required|string|unique:posts,slug',
            'tag_id' => 'required',
            // 'status' =>'required',
            'category_id' =>'required',
            'image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
		]);
        $arr = array('status' => false);      
        if($validator->passes()){ 
            
            if($request->status == true) {
                $status = 1;
            } else if($request->status == false) {
                $status = 0;
            }     
            $post = Post::create([
                'title'=>$request->title,
                'slug'=>$request->slug,
                'category_id'=>$request->category_id,
                'status' => $status,
                'user_id'=>1,
                ]); 
            $post->tag()->sync($request->input('tag_id'));
            if($request['image']) {
                $file = $request->file('image');
                $path = 'posts/';
                $image = $this->ImageUploader($file,$path);
                $photo = new Image();
                $photo->url = $image;
                $l = $post->images()->save($photo);
                $pic = ['path'=>$image];
            } 
            
           
            if(!empty($post->tag->first())) {
                foreach($post->tag as $item) {
                    $tags[] = $item->title;
                }
            }  
            $category = $post->category;
            $user = $post->user;
            $arr = array('status' => true);
         
            return response(["post"=>$post, 'user'=>$user, "arr"=>$arr, "tags" => $tags, 'pic'=>$pic, 'category'=>$category]);
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
            $post = Post::findOrFail($id);
            $pic = ['path'=>$post->images()->first()->url];
            $category = $post->category;
           
            foreach($post->tag as $item) {
                $tags[] = $item->title;
            }
            $user = $post->user;
            
            return response()->json(['post' => $post, 'user'=>$user, 'tags' => $tags, 'pic' => $pic, 'category'=>$category]);
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
            'title' => 'required',
            'slug' => 'required|string',
            'tag_id' => 'required',
            'category_id' => 'required',
            // 'status' =>'required',
            'image' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
		]);
        $arr = array('status' => false);      
        $post = Post::find($request->value_id);

        if($validator->passes()){ 
            
            if($request->status == true) {
                $status = 1;
            } else if($request->status == false) {
                $status = 0;
            }     
            
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->category_id = $request->category_id;
            $post->status = $status;
            $post->user_id = 1;
            $post->update();

            $post->tag()->sync($request->input('tag_id'));
            if($request['image']) {
                $file = $request->file('image');
                $path = 'posts/';
                $image = $this->ImageUploader($file,$path);
                $photo = $post->images()->first();
                unlink($photo->url) or die('Delete Error');
                $photo->url = $image;
                $photo->update();
                $pic = ['path'=>$image];
            } else {
                $pic = ['path'=>$post->images()->first()->url];
            }
           
            if(!empty($post->tag->first())) {
                foreach($post->tag as $item) {
                    $tags[] = $item->title;
                }
            }  
            $user = $post->user;
            $category = $post->category;
            $arr = array('status' => true);
           
            return response(["post"=>$post, 'user'=>$user, "arr"=>$arr, "tags" => $tags, 'pic'=>$pic, 'category'=>$category]);
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
        $post = Post::find($id);
       
        if(!empty($post->images()->first()))
        {
            $photo = $post->images()->first();
            unlink($photo->url) or die('Delete Error');
            $photo->delete();    
        }
        $post = $post->delete();
        return response()->json($post);
    }
    /**
     * Create the description  post .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createDescription(Post $post) {
   
        $post = Post::where('slug', $post->slug)->first();
        return view('admin.pages.post.Description',compact('post'));
    }
     /**
     * Create the description  post .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveDescription(Request $request) {
        $post = Post::find($request->value_id);
        $post->description  = $request->description;
        $post->update();
        // dd('done');
        return redirect()->route('show.description',['post'=>$post]);
    }
      /**
     * show the description  post .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDescription(Post $post) {
        $post = Post::where('slug', $post->slug)->first();
        return view('admin.pages.post.show_description',compact('post'));
    }

     /**
     * Upload multi image for every  post .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request) {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
      
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
      
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
      
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
      
            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore);
            $msg = 'عکس با موفقیت آپلود شد!';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
    
}
