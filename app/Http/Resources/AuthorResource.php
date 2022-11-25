<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'username' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('d.m.Y'),
            'posts_count' => $this->posts->count(),
            'comments_count' => $this->comments->count(),
            'iconPath' => '/'.$this->icon_path,
            'description' => $this->description,
        ];
    }
}
