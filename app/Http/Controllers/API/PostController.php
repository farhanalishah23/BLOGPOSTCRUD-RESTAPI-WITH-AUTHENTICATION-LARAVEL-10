<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts'] = Post::all();
        return response()->json([
            'status' => true,
            'message' => "All Posts Fetches Successfully! ",
            "data" => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedPost =  Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpeg,jpg,gif',
            ]
        );
        if ($validatedPost->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Post is not Validated",
                "error" => $validatedPost->errors()->all(),
            ], 401);
        }

        $image = $request->image;
        $imageExtention = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $imageExtention;
        $image->move(public_path() . '/uploads', $imageName);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' =>  $imageName,
        ]);
        if ($post) {
            return response()->json([
                'status' => true,
                'message' => "post created successfully!",
                "post" => $post
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::select('id', 'title', 'description', 'image')->where(['id' => $id])->get();
        if ($post) {
            return response()->json([
                'status' => true,
                'message' => "single post fetched successfully!",
                "post" => $post
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedPost =  Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpeg,jpg,gif',
            ]
        );
        if ($validatedPost->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Post is not Validated",
                "error" => $validatedPost->errors()->all(),
            ], 401);
        }

        $postImage = Post::select('id', 'image')->get();
        if ($request->image != '') {
            $path = public_path() . './uploads';
            if ($postImage->image != '' && $postImage->image != null) {
                $old_img = $path . $postImage->image;
                if (file_exists($old_img)) {
                    unlink($old_img);
                }
            }
            $image = $request->image;
            $imageExtention = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $imageExtention;
            $image->move(public_path() . '/uploads', $imageName);
        } else {
            $imageName =  $postImage->image;
        }

        $post = Post::where(['id' => $id])->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' =>  $imageName,
        ]);
        if ($post) {
            return response()->json([
                'status' => true,
                'message' => "post created successfully!",
                "post" => $post
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the post by ID
        $post = Post::find($id);
    
        // Check if post exists
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => "Post not found!"
            ], 404);
        }
    
        // Define the correct file path
        $filePath = public_path('uploads') . '/' . $post->image;
    
        // Check if the image exists and delete it
        if (!empty($post->image) && file_exists($filePath)) {
            unlink($filePath);
        }
    
        // Delete the post record
        $post->delete();
    
        // Return success response
        return response()->json([
            'status' => true,
            'message' => "Post deleted successfully!",
            "post" => $post
        ], 200);
    }
}
