<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
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
            'valeur' => $this->valeur,
            'question_id' => $this->question_id,
            'bonne_response' => $this->bonne_response,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
