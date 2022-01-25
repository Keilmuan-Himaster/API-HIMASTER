<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
         'category' => Category::where('id', $this->category_id)->first(),
         'body' => $this->body,
         'slug' => $this->slug,
         'media' => MediaResource::collection($this->files),
         'created_at' => $this->created_at,
         'updated_at' => $this->updated_at,

      ];
   }
}
