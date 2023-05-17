<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponsesQuizzAPIRequest;
use App\Http\Requests\API\UpdateResponsesQuizzAPIRequest;
use App\Models\ResponsesQuizz;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ResponsesQuizzController
 * @package App\Http\Controllers\API
 */

class ResponsesQuizzAPIController extends AppBaseController
{
    /**
     * Display a listing of the ResponsesQuizz.
     * GET|HEAD /responsesQuizzs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ResponsesQuizz::query();  

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $responsesQuizzs = $query->get();

        return $this->sendResponse($responsesQuizzs->toArray(), 'Responses Quizzs retrieved successfully');
    }

    /**
     * Store a newly created ResponsesQuizz in storage.
     * POST /responsesQuizzs
     *
     * @param CreateResponsesQuizzAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResponsesQuizzAPIRequest $request)
    {
        $input = $request->all();

        /** @var ResponsesQuizz $responsesQuizz */
        $responsesQuizz = ResponsesQuizz::create($input);

        return $this->sendResponse($responsesQuizz->toArray(), 'Responses Quizz saved successfully');
    }

    /**
     * Display the specified ResponsesQuizz.
     * GET|HEAD /responsesQuizzs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ResponsesQuizz $responsesQuizz */
        $responsesQuizz = ResponsesQuizz::find($id);

        if (empty($responsesQuizz)) {
            return $this->sendError('Responses Quizz not found');
        }

        return $this->sendResponse($responsesQuizz->toArray(), 'Responses Quizz retrieved successfully');
    }

    /**
     * Update the specified ResponsesQuizz in storage.
     * PUT/PATCH /responsesQuizzs/{id}
     *
     * @param int $id
     * @param UpdateResponsesQuizzAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResponsesQuizzAPIRequest $request)
    {
        /** @var ResponsesQuizz $responsesQuizz */
        $responsesQuizz = ResponsesQuizz::find($id);

        if (empty($responsesQuizz)) {
            return $this->sendError('Responses Quizz not found');
        }

        $responsesQuizz->fill($request->all());
        $responsesQuizz->save();

        return $this->sendResponse($responsesQuizz->toArray(), 'ResponsesQuizz updated successfully');
    }

    /**
     * Remove the specified ResponsesQuizz from storage.
     * DELETE /responsesQuizzs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ResponsesQuizz $responsesQuizz */
        $responsesQuizz = ResponsesQuizz::find($id);

        if (empty($responsesQuizz)) {
            return $this->sendError('Responses Quizz not found');
        }

        $responsesQuizz->delete();

        return $this->sendSuccess('Responses Quizz deleted successfully');
    }
}
