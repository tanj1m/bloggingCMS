<?php

namespace App\Http\Controllers;

use App\Setting;

use App\Catagory;

use App\Post;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    //Displaying homepage index

    public function index()
    {

    	
    	return view('index')
    		   ->with('title', Setting::first()->site_name)
    		   ->with('catagories', Catagory::take(10)->get())
    		   ->with('first_post', Post::orderBy('created_at', 'desc')->first())
    		   ->with('second_post', Post::orderBy('created_at','desc')->skip(1)->take(1)->get()->first())
    		   ->with('third_post', Post::orderBy('created_at','desc')->skip(2)->take(1)->get()->first())
    		   ->with('InfoSec',Catagory::find(5))
    		   ->with('Coding', Catagory::find(3))
    		   ->with('settings', Setting::first());
    }

    public function singlePost($slug)
    {
    	$post = Post::where('slug', $slug)->first();

    	$next_id = Post::where('id', '>', $post->id)->min('id');

    	$prev_id = Post::where('id', '<', $post->id)->max('id');

    	return view('single')->with('post', $post)
				
			   ->with('title', $post->title)
			   ->with('settings', Setting::first())
    		   ->with('catagories', Catagory::take(10)->get())
    		   ->with('next', Post::find($next_id))
    		   ->with('prev', Post::find($prev_id));

    }
}
