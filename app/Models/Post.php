<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Post",
    description: "Post model",
    properties: [
        new OA\Property(property: "id", description: "ID of the post", type: "integer"),
        new OA\Property(property: "user_id", description: "ID of the user who created the post", type: "integer"),
        new OA\Property(property: "title", description: "Title of the post", type: "string"),
        new OA\Property(property: "content", description: "Content of the post", type: "string"),
        new OA\Property(property: "published_at", description: "Publication date and time of the post", type: "string", format: "date-time"),
        new OA\Property(property: "published", description: "Publication status of the post", type: "boolean")
    ],
)]
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'published_at',
        'published'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
