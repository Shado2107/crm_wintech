<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'libelle' => $this->libelle,
            'type' => $this->type,
            'quizz_id' => $this->quizz_id,
            'roue_de_vie_id' => $this->roue_de_vie_id,
            'canva_mini_disq_id' => $this->canva_mini_disq_id,
            'domaine_id' => $this->domaine_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
