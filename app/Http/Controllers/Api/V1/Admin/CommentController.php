<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\SearchCommentRequest;
use App\Http\Requests\Admin\Comment\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Routing\Controllers\HasMiddleware;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post as PostMethod;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Response as OpenApiResponse;
class CommentController extends Controller implements HasMiddleware
{
    #[Get(
        path: '/api/v1/comments',
        summary: 'Get all comments',
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 200, description: "Get list of all comments.", content: new JsonContent()),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function index(): \Illuminate\Http\JsonResponse
    {
        $comments = Comment::with('post')->paginate(8);
        return response()->json($comments);
    }

    #[PostMethod(
        path: '/api/v1/comments',
        summary: 'Create a new comment',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/StoreCommentRequest'
            )
        ),
        tags: ['Comments'],
        responses: [
            new OpenApiResponse(response: 201, description: "Comment created successfully."),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function store(StoreCommentRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $comment = new Comment($data);
        $comment->save();
        return response()->json(['comment' => $comment->withoutRelations()]);
    }

    #[Get(
        path: '/api/v1/comments/{id}',
        summary: 'Get a single comment',
        tags: ['Comments'],
        responses: [
            new OpenApiResponse(response: 200, description: "Get a single comment."),
            new OpenApiResponse(response: 404, description: "Comment not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $comment = Comment::with( 'post')->find($id);
        if ($comment == null) {
            return response()->json(['error' => 'Comment not found'], 404);
        }
        return response()->json($comment);
    }

    #[Put(
        path: '/api/v1/comments/{id}',
        summary: 'Update an existing comment',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/StoreCommentRequest'
            )
        ),
        tags: ['Comments'],
        responses: [
            new OpenApiResponse(response: 200, description: "Comment updated successfully."),
            new OpenApiResponse(response: 404, description: "Comment not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function update(StoreCommentRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $comment = Comment::with('post')->find($id);
        $comment->update($data);
        return response()->json(['comment' => $comment->withoutRelations()]);
    }

    #[Delete(
        path: '/api/v1/comments/{id}',
        summary: 'Delete a comment',
        tags: ['Comments'],
        responses: [
            new OpenApiResponse(response: 200, description: "Comment successfully deleted."),
            new OpenApiResponse(response: 404, description: "Comment not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function destroy(string $id)
    {
        $comment = Comment::with('post')->find($id);
        if ($comment == null) {
            return response()->json(['error' => 'Comment not found'], 404);
        }
        $comment->delete();
        return response()->json(['message' => 'Comment successfully deleted']);
    }

    #[PostMethod(
        path: '/api/v1/comments/search',
        summary: 'Search comment',
        requestBody: new \OpenApi\Attributes\RequestBody(
            content: new \OpenApi\Attributes\JsonContent(
                ref: '#/components/schemas/SearchCommentRequest'
            )),
        tags: ['Tags'],
        responses: [
            new OpenApiResponse(response: 201, description: "Comment found."),
            new OpenApiResponse(response: 404, description: "Comment not found"),
            new OpenApiResponse(response: 403, description: "Unauthorized"),
        ]
    )]
    public function search(SearchCommentRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();
        $comments = Comment::with('post')->where(function ($query) use ($request) {
            $query->where('content', 'LIKE', '%' . $request->get('search') . '%');
        })->paginate(8);
        return response()->json($comments);
    }

    public static function middleware()
    {
        return [
            'admin'
        ];
    }
}
