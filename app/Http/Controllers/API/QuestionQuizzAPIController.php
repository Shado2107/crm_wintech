<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuestionQuizzAPIRequest;
use App\Http\Requests\API\UpdateQuestionQuizzAPIRequest;
use App\Models\QuestionQuizz;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class QuestionQuizzController
 * @package App\Http\Controllers\API
 */

class QuestionQuizzAPIController extends AppBaseController
{
    /**
     * Display a listing of the QuestionQuizz.
     * GET|HEAD /questionQuizzs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = QuestionQuizz::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $questionQuizzs = $query->get();

        return $this->sendResponse($questionQuizzs->toArray(), 'Questions Quizzs retrieved successfully');
    }

    /**
     * Store a newly created QuestionQuizz in storage.
     * POST /questionQuizzs
     *
     * @param CreateQuestionQuizzAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionQuizzAPIRequest $request)
    {
        $input = $request->all();

        /** @var QuestionQuizz $questionQuizz */
        $questionQuizz = QuestionQuizz::create($input);

        return $this->sendResponse($questionQuizz->toArray(), 'Questions Quizz saved successfully');
    }

    /**
     * Display the specified QuestionQuizz.
     * GET|HEAD /questionQuizzs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var QuestionQuizz $questionQuizz */
        $questionQuizz = QuestionQuizz::find($id);

        if (empty($questionQuizz)) {
            return $this->sendError('Questions Quizz not found');
        }

        return $this->sendResponse($questionQuizz->toArray(), 'Questions Quizz retrieved successfully');
    }

    /**
     * Update the specified QuestionQuizz in storage.
     * PUT/PATCH /questionQuizzs/{id}
     *
     * @param int $id
     * @param UpdateQuestionQuizzAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionQuizzAPIRequest $request)
    {
        /** @var QuestionQuizz $questionQuizz */
        $questionQuizz = QuestionQuizz::find($id);

        if (empty($questionQuizz)) {
            return $this->sendError('Questions Quizz not found');
        }

        $questionQuizz->fill($request->all());
        $questionQuizz->save();

        return $this->sendResponse($questionQuizz->toArray(), 'QuestionQuizz updated successfully');
    }

    /**
     * Remove the specified QuestionQuizz from storage.
     * DELETE /questionQuizzs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var QuestionQuizz $questionQuizz */
        $questionQuizz = QuestionQuizz::find($id);

        if (empty($questionQuizz)) {
            return $this->sendError('Questions Quizz not found');
        }

        $questionQuizz->delete();

        return $this->sendSuccess('Questions Quizz deleted successfully');
    }
}
