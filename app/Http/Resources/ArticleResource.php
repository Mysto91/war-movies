<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Util\Format\formatLinks;

class ArticleResource extends JsonResource
{
    use formatLinks;

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
            'description' => $this->description,
            'format' => $this->format,
            'rate' => $this->rate,
            'trailerUrl' => $this->trailer_url,
            'imageUrl' => $this->image_url,
            'releaseDate' => $this->release_date,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            '_links' => formatLinks::links($request->path(), $this->id)
        ];
    }
}
