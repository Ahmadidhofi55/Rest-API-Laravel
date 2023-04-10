<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index()
    {
       $posts = Post::latest()->get();
       return new PostResource(true, 'List Data Posts', $posts);
    }

    //input postingan into database
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required',
            'title'     => 'required',
            'contend'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'contend'   => $request->contend,
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

   //details data
   public function show($id)
   {
     $post =  Post::find($id);

     return new PostResource(true, 'Detail Data Post!', $post);
   }

   public function update(Request $request,$id)
   {

    //define validation rules
    $validator = Validator::make($request->all(), [
        'image'     => 'required',
        'title'     => 'required',
        'contend'   => 'required',
    ]);

    //check if validation fails
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    //find id
    $post = Post::find($id);

    if ($request->hasFile('image')) {

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //delete old image
        Storage::delete('public/posts/'.basename($post->image));

        //update post with new image
        $post->update([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

    } else {

        //update post without image
        $post->update([
            'title'     => $request->title,
            'content'   => $request->content,
        ]);
    }

    //return response
    return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
   }

   public function destroy($id){
    //find id
    $post = Post::find($id);

    Storage::delete('public/post/'.basename($post->image));

    //delete post
    $post->delete();

     //return response
     return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
   }
}
