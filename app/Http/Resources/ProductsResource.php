<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'small_desc' => $this->small_desc,
            'category_id' => $this->category_id,
            'big_desc' => $this->big_desc,
            'price' => $this->price,
            'reviews' => $this->reviews,
            'related' => $this->related,
            'images' => $this->images,
            'image' => $this->images[0] ?? null,
            'type' => $this->when($this->type, $this->type),
        ];
    }
}
