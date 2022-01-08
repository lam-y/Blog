<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Comment;
use App\Post;
use Session;
use Validator;
use DB;

class CommentsController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except('show');   
    }

    /** ********************************************************************
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::select('comments.*', 'posts.title' )
                            ->join('posts', 'comments.post_id', '=',  'posts.id') 
                            ->orderBy('approved', 'Asc')
                            ->orderBy('created_at', 'Desc')
                            ->paginate(15);                       

        //$comments = Comment::orderByDesc('created_at')->paginate(10);

        return view('back-end.comments-admin-panel', compact('comments'));
    }

    /** **********************************************************************
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /** **********************************************************************
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        // 1- validate the data  
        $rules = $this->rules();
        $messages = $this->messages();    
        //$request->validate($request, $rules, $messages);
        $validator = Validator::make($request->all(),$rules, $messages);
       
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // 2- store in the database
        $comment = new Comment();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->approved = false;              // حالياً رح نحفظ أي تعليق بدون موافقة الادمن

        $post = Post::find($post_id);

        $comment->post()->associate($post);        

        $comment->save();

        Session::flash('success', 'Thanks for your comment. It will appear when be approved');

        // 3- redirect
        return redirect()->route('post.show',$post->id);
    }

    /** **********************************************************************
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /** **********************************************************************
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /** **********************************************************************
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve_comment($id)
    {
        $comment = Comment::find($id);

        if($comment){
            $comment->update([
                $comment->approved = true,
            ]);          
        }

        return redirect()->route('comments.index');        
    }

    /** **********************************************************************
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

    /** **********************************************************************
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if($comment){
            $comment->delete();
        }

        return redirect()->route('comments.index');
    }


     /** ************************************************************************
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',             
            'email' => 'required|email|max:255',
            'comment' => 'required|max:2000',
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
            'name.required' => 'A name is required',
            'email.required' => 'The email is required',
            'comment.image' => 'Where is your comment?!',
        ];
    }
}
