<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'title' => $this->title,
            'small_desc' => $this->small_desc,
            'category_id' => $this->category_id,
            'big_desc' => $this->big_desc,
            'price' => $this->price,
            'images' => $this->images,
            'image' => $this->images[0] ?? null
        ];
    }
}
