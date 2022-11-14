<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
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
            // 'meta' => [
            //     'currentPage' => $this->current_page,
            //     'totalItems' => $this->from,

            // ],
            'data' => [
                'id' => $this->id,
                'title' => $this->title,
                'description' =>$this->description,
                'slug' => $this->slug,
                'category' => $this->categories,
                'tags' => $this->tags,
                'ingredients' => $this->ingredients,
                'links' => [
                    'prev' => $this->prev_page_url,
                ],
            ]
        ];
    }
}
