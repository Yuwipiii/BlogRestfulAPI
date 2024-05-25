<?php

namespace App\Http\Requests\Admin\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StoreCommentRequest",
    required: ["user_id","title", "content", "tags"],
    properties: [
        new OA\Property("user_id", type: "integer"),
        new OA\Property("post_id", type: "integer"),
        new OA\Property(property: "content", type: "string"),
    ]
)]
class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>['required','exists:users,id'],
            'post_id'=>['required','exists:posts,id'],
            'content'=>['required','string','min:5','max:1024'],
        ];
    }
}
