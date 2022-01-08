<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Mail;
use Session;

class PagesController extends Controller
{
    /** **************************************************************
     * 
     */

    public function getIndex(){
        $posts = Post::orderByDesc('id')->paginate(8);

        return view('pages.index', compact('posts')); 
    }

    /** **************************************************************
     * 
     */
    public function getAbout(){        
        return view('pages/about');
    }

    /** **************************************************************
     * 
     */
    public function getContact(){
        return view('pages/contact');
    }

    /** **************************************************************
     * 
     */
    public function postContact(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'message' => 'required'
            ]);

            $data = array(
                'name' => $request->name,
                'email' => $request->email,
                'bodyMessage' => $request->message         
            );
            Mail::send('emails.contact', $data, function($message) use($data){
                $message->from($data['email']);
                $message->to('lamisyat@gmail.com');
                $message->subject($data['bodyMessage']);
            });

            Session::flash('success', 'Your email was sent');

            return redirect('/');
    }

}
