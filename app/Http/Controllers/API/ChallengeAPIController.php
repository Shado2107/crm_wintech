<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatechallengeAPIRequest;
use App\Http\Requests\API\UpdatechallengeAPIRequest;
use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ChallengeController
 * @package App\Http\Controllers\API
 */

class ChallengeAPIController extends AppBaseController
{
    /**
     * Display a listing of the challenge.
     * GET|HEAD /challenges
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Challenge::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $challenges = $query->get();

        return $this->sendResponse($challenges->toArray(), 'Challenges retrieved successfully');
    }

    /**
     * Store a newly created challenge in storage.
     * POST /challenges
     *
     * @param CreatechallengeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatechallengeAPIRequest $request)
    {
        $input = $request->all();

        /** @var challenge $challenge */
        $challenge = Challenge::create($input);

        return $this->sendResponse($challenge->toArray(), 'Challenge saved successfully');
    }

    /**
     * Display the specified challenge.
     * GET|HEAD /challenges/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var challenge $challenge */
        $challenge = Challenge::find($id);

        if (empty($challenge)) {
            return $this->sendError('Challenge not found');
        }

        return $this->sendResponse($challenge->toArray(), 'Challenge retrieved successfully');
    }

    /**
     * Update the specified challenge in storage.
     * PUT/PATCH /challenges/{id}
     *
     * @param int $id
     * @param UpdatechallengeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatechallengeAPIRequest $request)
    {
        /** @var challenge $challenge */
        $challenge = Challenge::find($id);

        if (empty($challenge)) {
            return $this->sendError('Challenge not found');
        }

        $challenge->fill($request->all());
        $challenge->save();

        return $this->sendResponse($challenge->toArray(), 'challenge updated successfully');
    }

    /**
     * Remove the specified challenge from storage.
     * DELETE /challenges/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var challenge $challenge */
        $challenge = Challenge::find($id);

        if (empty($challenge)) {
            return $this->sendError('Challenge not found');
        }

        $challenge->delete();

        return $this->sendSuccess('Challenge deleted successfully');
    }
}
