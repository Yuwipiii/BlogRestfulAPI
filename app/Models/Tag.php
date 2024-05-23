<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Tag",
    description: "Tag model",
    properties: [
        new OA\Property(property: "id", description: "ID of the tag", type: "integer"),
        new OA\Property(property: "name", description: "Name of the tag", type: "string"),
    ],
)]
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id');
    }
}
