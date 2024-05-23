<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Post as PostMethod;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Info;
use OpenApi\Attributes\Response as OpenApiResponse;
use OpenApi\Attributes\Tag;

#[Info(
    version: '1.0',
    title: 'Blog Restful Api',
)]
class PostController extends Controller implements HasMiddleware
{
    #[Get(
        path: '/api/v1/posts',
        summary: 'Get all posts',
        tags: ['Posts'],
        responses: [
            new OpenApiResponse(response: 200, description: "Get list of all posts."),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function index(): JsonResponse
    {
        $posts = Post::with('user', 'tags')->paginate(8);
        return response()->json($posts);
    }

    #[PostMethod(
        path: '/api/v1/posts',
        summary: 'Create a new post',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/StorePostRequest'
            )
        ),
        tags: ['Posts'],
        responses: [
            new OpenApiResponse(response: 201, description: "Post created successfully."),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function store(StorePostRequest $request): JsonResponse
    {
        $data = $request->validated();
        $post = new Post($data);
        if ($data['published']) {
            $post->published_at = date('Y-m-d H:i:s');
        }
        $post->save();
        foreach ($data['tags'] as $tag) {
            $post->tags()->attach($tag);
        }
        return response()->json(['post' => $post->withoutRelations(), 'tags' => $post->tags]);
    }

    #[Get(
        path: '/api/v1/posts/{id}',
        summary: 'Get a single post',
        tags: ['Posts'],
        responses: [
            new OpenApiResponse(response: 200, description: "Get a single post."),
            new OpenApiResponse(response: 404, description: "Post not found"),
        ]
    )]
    public function show(string $id): JsonResponse
    {
        $post = Post::with('tags', 'comments')->find($id);
        if ($post == null) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        return response()->json($post);
    }

    #[Put(
        path: '/api/v1/posts/{id}',
        summary: 'Update an existing post',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/StorePostRequest'
            )
        ),
        tags: ['Posts'],
        responses: [
            new OpenApiResponse(response: 200, description: "Post updated successfully."),
            new OpenApiResponse(response: 404, description: "Post not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function update(StorePostRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();
        $post = Post::with('tags')->find($id);
        if ($post == null) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        if ($data['published']) {
            $post->published_at = date('Y-m-d H:i:s');
        }
        $post->update($data);
        $post->tags()->detach();
        foreach ($data['tags'] as $tag) {
            $post->tags()->attach($tag);
        }
        return response()->json(['post' => $post->withoutRelations(), 'tags' => $post->tags]);
    }

    #[Delete(
        path: '/api/v1/posts/{id}',
        summary: 'Delete a post',
        tags: ['Posts'],
        responses: [
            new OpenApiResponse(response: 200, description: "Post successfully deleted."),
            new OpenApiResponse(response: 404, description: "Post not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function destroy(string $id): JsonResponse
    {
        $post = Post::with('tags', 'comments')->find($id);
        if ($post == null) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post successfully deleted']);
    }

    public static function middleware(): array
    {
        return [
            'admin'
        ];
    }
}
