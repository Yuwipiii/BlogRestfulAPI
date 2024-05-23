<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = Post::with('user','tags')->paginate(8);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $data = $request->validated();
        $post = new Post($data);
        if($data['published']){
            $post->published_at = date('Y-m-d H:i:s');
        }
        $post->save();
        foreach ($data['tags'] as $tag) {
            $post->tags()->attach($tag);
        }
        return response()->json(['post'=>$post->withoutRelations(),'tags'=>$post->tags]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $post = Post::with('tags','comments')->find($id);
        if($post == null){
            return response()->json(['error'=>'Post not found']);
        }
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();
        $post = Post::with('tags')->find($id);
        if($post == null){
            return response()->json(['error'=>'Post not found']);
        }
        if($data['published']){
            $post->published_at = date('Y-m-d H:i:s');
        }
        $post->update($data);
        $post->tags()->detach();
        foreach ($data['tags'] as $tag) {
            $post->tags()->attach($tag);
        }
        return response()->json(['post'=>$post->withoutRelations(),'tags'=>$post->tags]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $post = Post::with('tags','comments')->find($id);
        if($post == null){
            return response()->json(['error'=>'Post not found']);
        }
        $post->delete();
        return response(['message'=>'Post successfully deleted']);
    }

    public static function middleware(): array
    {
        return [
            'admin'
        ];
    }
}
