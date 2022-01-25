<?php

namespace App\Http\Resources;

use App\Models\Structure;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
         'name' => $this->name,
         'divisi' => Structure::find($this->structure_id),
         'address' => $this->address,
         'nim' => $this->nim,
         'prodi' => $this->majors,
         'angkatan' => $this->year,
         'priode' => $this->priode,
         'jabatan' => $this->grade,
         'media' => MediaResource::collection($this->files),
      ];
   }
}
