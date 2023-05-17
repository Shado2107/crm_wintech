<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponseAPIRequest;
use App\Http\Requests\API\UpdateResponseAPIRequest;
use App\Models\Reponse;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ResponseResource;
use Response;

/**
 * Class ResponseController
 * @package App\Http\Controllers\API
 */

class ResponseAPIController extends AppBaseController
{
    /** @var  ResponseRepository */
    private $responseRepository;

    public function __construct(ResponseRepository $responseRepo)
    {
        $this->responseRepository = $responseRepo;
    }

    /**
     * Display a listing of the Response.
     * GET|HEAD /responses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $responses = $this->responseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ResponseResource::collection($responses), 'Responses retrieved successfully');
    }

    /**
     * Store a newly created Response in storage.
     * POST /responses
     *
     * @param CreateResponseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResponseAPIRequest $request)
    {
        $input = $request->all();

        $response = $this->responseRepository->create($input);

        return $this->sendResponse(new ResponseResource($response), 'Response saved successfully');
    }

    /**
     * Display the specified Response.
     * GET|HEAD /responses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Response $response */
        $response = $this->responseRepository->find($id);

        if (empty($response)) {
            return $this->sendError('Response not found');
        }

        return $this->sendResponse(new ResponseResource($response), 'Response retrieved successfully');
    }

    /**
     * Update the specified Response in storage.
     * PUT/PATCH /responses/{id}
     *
     * @param int $id
     * @param UpdateResponseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResponseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Response $response */
        $response = $this->responseRepository->find($id);

        if (empty($response)) {
            return $this->sendError('Response not found');
        }

        $response = $this->responseRepository->update($input, $id);

        return $this->sendResponse(new ResponseResource($response), 'Response updated successfully');
    }

    /**
     * Remove the specified Response from storage.
     * DELETE /responses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Response $response */
        $response = $this->responseRepository->find($id);

        if (empty($response)) {
            return $this->sendError('Response not found');
        }

        $response->delete();

        return $this->sendSuccess('Response deleted successfully');
    }
}
