<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Rules\MaxPostsRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    function __construct(){
        $this->middleware('auth:sanctum')->only('store');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $post_validation = Validator::make($request->all(), [
            "title" => [
                "required",
                "min:3",
                "unique:posts,title",
                new MaxPostsRule(3)
            ],
            "image" => "image|mimes:jpeg,jpg,png|max:2048",
            "description" => "required|min:10",
            "creator_id" => [
                'required',
                'exists:creators,id'
            ]
        ]);

        if ($post_validation->fails()) {
            return response()->json([
                "message"=> "errors with request params",
                "errors"=> $post_validation->errors()
                ],422);
        }

        $image_path = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store("", 'posts_images');
        }

        $request_data = $request->except('slug');
        $request_data['image'] = $image_path;
        $request_data['creator_id'] = Auth::id();

        $post = Post::create($request_data);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post_validation = Validator::make($request->all(), [
            "title" => "required",
            "description" => "required|min:10",
            "image" => "nullable|image|mimes:jpeg,jpg,png|max:2048"
        ]);

        if ($post_validation->fails()) {
            return response()->json([
                "message"=> "errors with request params",
                "errors"=> $post_validation->errors()
                ],422);
        }

        $image_path = $post->image;

        if ($request->hasFile('image')) {
            if($image_path){
                Storage::disk('posts_images')->delete($image_path);
            }
            $image = $request->file('image');
            $image_path = $image->store("images", 'posts_images');
        }

        $request_data = $request->except('slug');
        $request_data = request()->all();
        $request_data['image'] = $image_path;

        $post->update($request_data);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->image){
            Storage::disk('posts_images')->delete($post->image);
        }
        $post->delete();
        return response()->json([
            "message"=> "deleted"
            ],204);
    }
}
