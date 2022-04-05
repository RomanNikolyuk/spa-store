<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlidersResource extends JsonResource
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
            'small_text_1' => $this->small_text_1,
            'small_text_2' => $this->small_text_2,
            'big_text' => $this->big_text,
            'button_text' => $this->button_text,
            'url' => $this->url,
            'image' => $this->image->title
        ];
    }
}
