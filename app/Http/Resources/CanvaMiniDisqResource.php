<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CanvaMiniDisqResource extends JsonResource
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
            'row' => $this->row,
            'column' => $this->column,
            'couleur_id' => $this->couleur_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
