<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprenantResource extends JsonResource
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
            'user_id' => $this->user_id,
            'couleur_id' => $this->couleur_id,
            'telephone' => $this->telephone,
            'whatsapp' => $this->whatsapp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
