<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Comment",
    description: "Comment model",
    properties: [
        new OA\Property(property: "id", description: "ID of the comment", type: "integer"),
        new OA\Property(property: "post_id", description: "ID of the post", type: "integer"),
        new OA\Property(property: "content", description: "Content of the comment", type: "string"),
    ],
)]
class Comment extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'post_id',
        'content'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
