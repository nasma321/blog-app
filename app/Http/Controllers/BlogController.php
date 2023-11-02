<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::all();
        return view('blogs.index', compact('blogs'));
    }

    public function store(Request $request){
        $blog = Blog::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'title' => $request->title, 
                'content' => $request->content
            ]);

        return response()->json(['success' => true]);
    }

    public function show(Request $request, $id){
        $blog = Blog::where('id', '=', $id)->first();
        if(isset($request->view) && $request->view == 1){
            return view('blogs.show', compact('blog'));
        }else{
            return response()->json($blog);
        }
    }

    public function destroy(Request $request)
    {
        $blog = Blog::where('id', '=', $request->id)->delete();
   
        return response()->json(['success' => true]);
    }
}
