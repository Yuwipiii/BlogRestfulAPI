<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StorePostRequest",
    required: ["user_id","title", "content", "tags"],
    properties: [
        new OA\Property("user_id", type: "integer"),
        new OA\Property(property: "title", type: "string"),
        new OA\Property(property: "content", type: "string"),
        new OA\Property(property: "tags", type: "array", items: new OA\Items(type: "integer")),
        new OA\Property(property: "published", type: "boolean")
    ]
)]
class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && Gate::check('is_admin', auth()->user());
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
            'title'=>['required','string','min:3','max:255'],
            'content'=>['required','string','min:5','max:1024'],
            'published'=>['required','boolean'],
            'tags'=>['nullable','array','exists:tags,id'],
        ];
    }
}
