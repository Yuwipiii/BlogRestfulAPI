<?php

namespace App\Http\Requests\Admin\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "StoreTagRequest",
    required: ['name'],
    properties: [
        new OA\Property(property: "name", type: "string"),
    ]
)]
class StoreTagRequest extends FormRequest
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
            'name' => ['required','string','unique:tags,name'],
        ];
    }
}
