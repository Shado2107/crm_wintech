<?php

namespace App\Http\Requests\API;

use App\Models\QuestionQuizz;
use InfyOm\Generator\Request\APIRequest;

class UpdateQuestionQuizzAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = QuestionQuizz::$rules;
        
        return $rules;
    }
}
