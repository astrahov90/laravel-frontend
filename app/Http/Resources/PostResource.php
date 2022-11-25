<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'body' => $this->body,
            'created_at' => $this->created_at->format('d.m.Y H:i:s'),
            'updated_at' => $this->updated_at->format('d.m.Y H:i:s'),
            'comments_count' => $this->comments->count(),
            'likes_count' => $this->rating->sum('rating'),
            'iconPath' => '/'.$this->author->icon_path,
            'authorName' => $this->author->name,
            'comments_count_text' => $this->comments->count(). " " . $this->getCommentSuffix($this->comments->count()),
        ];
    }

    private function getCommentSuffix($commentNum)
    {
        switch ($commentNum % 10) {
            case 1:
                switch ($commentNum) {
                    case 11:
                        return "комментариев";
                    default:
                        return "комментарий";
                }
            case 2:
            case 3:
            case 4:
                switch ($commentNum) {
                    case 12:
                    case 13:
                    case 14:
                        return "комментариев";
                    default:
                        return "комментария";
                }
            default:
                return "комментариев";
        }
    }
}
