<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuestionChallengeAPIRequest;
use App\Http\Requests\API\UpdateQuestionChallengeAPIRequest;
use App\Models\QuestionChallenge;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class QuestionChallengeController
 * @package App\Http\Controllers\API
 */

class QuestionChallengeAPIController extends AppBaseController
{
    /**
     * Display a listing of the QuestionChallenge.
     * GET|HEAD /questionChallenges
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = QuestionChallenge::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $questionChallenges = $query->get();

        return $this->sendResponse($questionChallenges->toArray(), 'Question Challenges retrieved successfully');
    }

    /**
     * Store a newly created QuestionChallenge in storage.
     * POST /questionChallenges
     *
     * @param CreateQuestionChallengeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionChallengeAPIRequest $request)
    {
        $input = $request->all();

        /** @var QuestionChallenge $questionChallenge */
        $questionChallenge = QuestionChallenge::create($input);

        return $this->sendResponse($questionChallenge->toArray(), 'Question Challenge saved successfully');
    }

    /**
     * Display the specified QuestionChallenge.
     * GET|HEAD /questionChallenges/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var QuestionChallenge $questionChallenge */
        $questionChallenge = QuestionChallenge::find($id);

        if (empty($questionChallenge)) {
            return $this->sendError('Question Challenge not found');
        }

        return $this->sendResponse($questionChallenge->toArray(), 'Question Challenge retrieved successfully');
    }

    /**
     * Update the specified QuestionChallenge in storage.
     * PUT/PATCH /questionChallenges/{id}
     *
     * @param int $id
     * @param UpdateQuestionChallengeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionChallengeAPIRequest $request)
    {
        /** @var QuestionChallenge $questionChallenge */
        $questionChallenge = QuestionChallenge::find($id);

        if (empty($questionChallenge)) {
            return $this->sendError('Question Challenge not found');
        }

        $questionChallenge->fill($request->all());
        $questionChallenge->save();

        return $this->sendResponse($questionChallenge->toArray(), 'QuestionChallenge updated successfully');
    }

    /**
     * Remove the specified QuestionChallenge from storage.
     * DELETE /questionChallenges/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var QuestionChallenge $questionChallenge */
        $questionChallenge = QuestionChallenge::find($id);

        if (empty($questionChallenge)) {
            return $this->sendError('Question Challenge not found');
        }

        $questionChallenge->delete();

        return $this->sendSuccess('Question Challenge deleted successfully');
    }
}
