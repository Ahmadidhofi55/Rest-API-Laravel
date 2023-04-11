<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Validator;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = Blog::latest()->get();
        return response()->json([
             'data' => BlogResource::collection($blog),
             'message' => 'Fetch All Blogs',
             'success' => true,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //data insert with validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:155',
            'content' => 'required',
            'status' => 'required'
        ]);

        // if failed validation with response and status false
        if($validator->fails()){
            return response()->json([
               'data'=> [],
               'message' => $validator->errors(),
               'success' => false,
            ]);
        }

        //if successful validation with insert blog
        $Blog = Blog::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('slug')),
        ]);

        //if insert true with response true and data insert
        return response()->json([
              'data'=> new BlogResource($Blog),
              'message' => 'Blog Created Successfully',
              'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return response()->json([
            'data'=> new BlogResource($blog),
            'message' => 'Blog Data Found',
            'success' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
          //data update with validation rules
          $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:155',
            'content' => 'required',
            'status' => 'required'
        ]);

        // if failed validation with response and status false
        if($validator->fails()){
            return response()->json([
               'data'=> [],
               'message' => $validator->errors(),
               'success' => false,
            ]);
        }

        //if validation true then update blog data
        $blog->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('slug')),
        ]);

        //if update true is repsone true and display data
        return response()->json([
            'data'=> new BlogResource($blog),
            'message' => 'Blog Updated Successfully',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //Blog delete
        $blog->delete();

        //if blog delete successfully 
        return response()->json([
            'data'=> [],
            'message' => 'Blog Delete Successfully',
            'success' => true,
        ]);
    }
}
