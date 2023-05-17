<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuizzAPIRequest;
use App\Http\Requests\API\UpdateQuizzAPIRequest;
use App\Models\Quizz;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class QuizzController
 * @package App\Http\Controllers\API
 */

class QuizzAPIController extends AppBaseController
{
    /**
     * Display a listing of the Quizz.
     * GET|HEAD /quizzs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Quizz::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $quizzs = $query->get();

        return $this->sendResponse($quizzs->toArray(), 'Quizzs retrieved successfully');
    }

    /**
     * Store a newly created Quizz in storage.
     * POST /quizzs
     *
     * @param CreateQuizzAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuizzAPIRequest $request)
    {
        $input = $request->all();

        /** @var Quizz $quizz */
        $quizz = Quizz::create($input);

        return $this->sendResponse($quizz->toArray(), 'Quizz saved successfully');
    }

    /**
     * Display the specified Quizz.
     * GET|HEAD /quizzs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Quizz $quizz */
        $quizz = Quizz::find($id);

        if (empty($quizz)) {
            return $this->sendError('Quizz not found');
        }

        return $this->sendResponse($quizz->toArray(), 'Quizz retrieved successfully');
    }

    /**
     * Update the specified Quizz in storage.
     * PUT/PATCH /quizzs/{id}
     *
     * @param int $id
     * @param UpdateQuizzAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuizzAPIRequest $request)
    {
        /** @var Quizz $quizz */
        $quizz = Quizz::find($id);

        if (empty($quizz)) {
            return $this->sendError('Quizz not found');
        }

        $quizz->fill($request->all());
        $quizz->save();

        return $this->sendResponse($quizz->toArray(), 'Quizz updated successfully');
    }

    /**
     * Remove the specified Quizz from storage.
     * DELETE /quizzs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Quizz $quizz */
        $quizz = Quizz::find($id);

        if (empty($quizz)) {
            return $this->sendError('Quizz not found');
        }

        $quizz->delete();

        return $this->sendSuccess('Quizz deleted successfully');
    }
}
