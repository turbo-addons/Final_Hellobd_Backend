<?php
// app/Http/Resources/NewsPostResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'slug' => $this->slug,
            'published_at' => $this->published_at,
            'feature_video_link' => $this->feature_video_link,
            'feature_image_link' => $this->feature_image_link,
            'media' => $this->whenLoaded('media', function () {
                return $this->media->map(function ($media) {
                    return [
                        'original_url' => $media->getFullUrl(), // অথবা $media->original_url
                    ];
                });
            }),
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'name_bn' => $category->name_bn,
                        'slug' => $category->slug,
                    ];
                });
            }),
        ];
    }
}