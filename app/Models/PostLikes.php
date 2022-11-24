<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostLikes
 *
 * @property int $id
 * @property int $author_id
 * @property int $post_id
 * @property int $rating
 * @property-read \App\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|PostLikes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLikes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLikes query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLikes whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLikes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLikes wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLikes whereRating($value)
 * @mixin \Eloquent
 */
class PostLikes extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;
}
