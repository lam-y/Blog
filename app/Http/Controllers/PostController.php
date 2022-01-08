<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Post;
use App\Category;
use Validator;
use DB;
use Session;
use Purifier;
use Image;
use Storage;


class PostController extends Controller
{

    /**
     * Constructor  
     */
    public function __construct(){
        $this->middleware('auth')->except('show', 'index', 'search', 'getPostsForCategory');     
    }


    /** *******************************************************************************
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = DB::table('posts')->select('id','title', 'body','created_at')->orderByDesc('created_at')->get();
        $posts = Post::orderByDesc('id')->paginate(5);        

        return view('pages.index', compact('posts'));
        //return view('back-end.admin-panel', compact('posts'));
    }

     /** *******************************************************************************
     *    
     */
    public function showAdminPanel()
    {    
        $posts = Post::orderByDesc('id')->paginate(10);
        return view('back-end.admin-panel', compact('posts'));
    }

    /** *********************************************************************************
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('categories')->get();

        return view('posts.create', compact('categories'));
    }

    /** ********************************************************************************
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1- validate the data  
        $rules = $this->rules();
        $messages = $this->messages();
        //$validator = Validator::make($request->all(),$rules, $messages);
        $this->validate($request, $rules, $messages);

        
        // 2- store in the database
        $post = new Post;
        $post->title = $request->title;
        $post->body = Purifier::clean($request->body);         
        
        // add image 
        if($request->hasfile('image')){
            // save the image in public/images folder
            $image = $request->file('image');            
            $fileName = time() . '.' . $image->getclientoriginalextension();        // to rename the image with a unique name
            $location = public_path('images/'.$fileName);

            $width = Image::make($image)->width();            
            $height = Image::make($image)->height();

            if($width > 800 && $height > 400){
                Image::make($image)->resize(null, 400, function ($constraint) {       
                    $constraint->aspectRatio();
                })->save($location);            
            }

            else{           // اذا ما غيرت أبعاد الصورة بحفظها مباشرة
                Image::make($image)->save($location);
            }

            // save fileName in the DB to find it later
            $post->image = $fileName;
        }

        if($request->category != 0){
            $post->category_id = $request->category;
        }

        $post->save();

        Session::flash('success', 'The post was successfully saved');

        // 3- redirect to another page
        return redirect()->route('post.show',$post->id);
                      //  ->with('success','post created successfully.');  
                      
    }

    /** ********************************************************************************
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);         

        return view('posts.show')->with('post', $post);
    }

    /** ********************************************************************************
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);        // search in database with id only

        $categories = DB::table('categories')->get();

        if(!$post){                     // if post deosn't exists in DB
            return redirect()->route('post.index');
        }

        return view('posts.edit', compact('post', 'categories') );      
    }

    /** ********************************************************************************
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //1- validate values
        $rules = $this->rules();
        $messages = $this->messages();
        $this->validate($request, $rules, $messages);

        //2- check if the post exists in the database
        $post = Post::find($id);

        if(!$post){     // if post deosn't exists in DB
            return redirect()->route('post.index');
        }        

        // some work with image   
        $newImage = false; 
        $fileName = "";            
        if($request->hasfile('image') ){
            $newImage = true;
            // Add the new image           
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getclientoriginalextension();    
            $location = public_path('images/'.$fileName);        

            $width = Image::make($image)->width();
            $height = Image::make($image)->height();

            if($width > 800 && $height > 400){
                Image::make($image)->resize(null, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($location);            
            }
            else{
                Image::make($image)->save($location);
            }

            $oldFileName = $post->image;

            // Delete the old image
            Storage::delete($oldFileName);
        }

        // 3- update in database 
        if($newImage){          // update with Image
            $post->update( [
                $post->title = $request->title,
                $post->body = Purifier::clean($request->body),        
                $post->image = $fileName,
                $post->category_id = $request->category,
            ]);
        }
        else{
            $post->update( [        // update without image, that means keep the old image
                $post->title = $request->title,
                $post->body = Purifier::clean($request->body), 
                $post->category_id = $request->category, 
            ]);
        }
        

        //4- redirect to another page with success message
        Session::flash('success', 'Changes Saved successfully');
        return  redirect()->route('post.show', $id);

    }

    /** ********************************************************************************
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //1- check if the post exists in the database
        $post = Post::find($id);

        if(!$post){     // if post deosn't exists in DB
            return redirect()->route('post.index');
        }

        // delete the image of the post
        Storage::delete($post->image);

        $post->delete();        

        //3- redirect to another page with success message
        Session::flash('success', 'The post deleted successfully');
        return redirect()->route('post.index');
    
    }

    /** *******************************************************************************
     * Search Function
     *
     */
    public function search(Request $request)
    {
        $posts = Post::where('title', 'LIKE', '%'.$request->term.'%')->paginate(5);      

        return view('pages.index', compact('posts'));        
    }


    /** ************************************************************************
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
             Rule::unique('posts')->ignore(request('post')),       
            'body' => 'required',
            'image' => 'sometimes|image',
            //'category_id' => 'integer',
        ];
    }

    /** *************************************************************************
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'body.required' => 'The post Body is required',
            'image.image' => 'The image is not valid',
        ];
    }

     /** ************************************************************************
     * Get all posts for one category
     *
     */
    public function getPostsForCategory($category_id)
    {
     
       $posts = Post::with('category')->where('category_id', '=', $category_id)->orderByDesc('created_at')->paginate(5);

        return view('pages.index', compact('posts')); 
    
    }
}
