<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\SearchPostRequest;
use App\Http\Requests\Admin\Tag\StoreTagRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post as PostMethod;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Response as OpenApiResponse;

class TagController extends Controller implements HasMiddleware
{
    #[Get(
        path: '/api/v1/tags',
        summary: 'Get all tags',
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 200, description: "Get list of all tags.", content: new JsonContent()),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function index(): \Illuminate\Http\JsonResponse
    {
        $tags = Tag::with('posts')->paginate(8);
        return response()->json($tags);
    }

    #[PostMethod(
        path: '/api/v1/tags',
        summary: 'Create a new tag',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/StoreTagRequest'
            )
        ),
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 201, description: "Tag created successfully."),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function store(StoreTagRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $tag = new Tag($data);
        $tag->save();
        return response()->json(['tag' => $tag->withoutRelations()]);
    }

    #[Get(
        path: '/api/v1/tag/{id}',
        summary: 'Get a single tag',
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 200, description: "Get a single tag."),
            new OpenApiResponse(response: 404, description: "Post not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $tag = Tag::with( 'posts')->find($id);
        if ($tag == null) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        return response()->json($tag);
    }

    #[Put(
        path: '/api/v1/tags/{id}',
        summary: 'Update an existing tag',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/StoreTagRequest'
            )
        ),
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 200, description: "Tag updated successfully."),
            new OpenApiResponse(response: 404, description: "Tag not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function update(StoreTagRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $tag = Tag::with('posts')->find($id);
        $tag->update($data);
        return response()->json(['tag' => $tag->withoutRelations()]);
    }

    #[Delete(
        path: '/api/v1/tags/{id}',
        summary: 'Delete a tag',
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 200, description: "Tag successfully deleted."),
            new OpenApiResponse(response: 404, description: "Tag not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function destroy(string $id)
    {
        $tag = Tag::with('posts')->find($id);
        if ($tag == null) {
            return response()->json(['error' => 'Tag not found'], 404);
        }
        $tag->delete();
        return response()->json(['message' => 'Tag successfully deleted']);
    }

    #[PostMethod(
        path: '/api/v1/tags/search',
        summary: 'Search tag',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/SearchTagRequest'
            )),
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 201, description: "Tag found."),
            new OpenApiResponse(response: 404, description: "Tag not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function search(SearchPostRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();
        $tags = Tag::with('posts')->where(function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->get('search') . '%');
        })->paginate(8);
        return response()->json($tags);
    }

    public static function middleware()
    {
        return [
            'admin'
        ];
    }
}
