<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCanvaMiniDisqAPIRequest;
use App\Http\Requests\API\UpdateCanvaMiniDisqAPIRequest;
use App\Models\CanvaMiniDisq;
use App\Repositories\CanvaMiniDisqRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CanvaMiniDisqResource;
use Response;

/**
 * Class CanvaMiniDisqController
 * @package App\Http\Controllers\API
 */

class CanvaMiniDisqAPIController extends AppBaseController
{
    /** @var  CanvaMiniDisqRepository */
    private $canvaMiniDisqRepository;

    public function __construct(CanvaMiniDisqRepository $canvaMiniDisqRepo)
    {
        $this->canvaMiniDisqRepository = $canvaMiniDisqRepo;
    }

    /**
     * Display a listing of the CanvaMiniDisq.
     * GET|HEAD /canvaMiniDisqs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $canvaMiniDisqs = $this->canvaMiniDisqRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CanvaMiniDisqResource::collection($canvaMiniDisqs), 'Canva Mini Disqs retrieved successfully');
    }

    /**
     * Store a newly created CanvaMiniDisq in storage.
     * POST /canvaMiniDisqs
     *
     * @param CreateCanvaMiniDisqAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCanvaMiniDisqAPIRequest $request)
    {
        $input = $request->all();

        $canvaMiniDisq = $this->canvaMiniDisqRepository->create($input);

        return $this->sendResponse(new CanvaMiniDisqResource($canvaMiniDisq), 'Canva Mini Disq saved successfully');
    }

    /**
     * Display the specified CanvaMiniDisq.
     * GET|HEAD /canvaMiniDisqs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CanvaMiniDisq $canvaMiniDisq */
        $canvaMiniDisq = $this->canvaMiniDisqRepository->find($id);

        if (empty($canvaMiniDisq)) {
            return $this->sendError('Canva Mini Disq not found');
        }

        return $this->sendResponse(new CanvaMiniDisqResource($canvaMiniDisq), 'Canva Mini Disq retrieved successfully');
    }

    /**
     * Update the specified CanvaMiniDisq in storage.
     * PUT/PATCH /canvaMiniDisqs/{id}
     *
     * @param int $id
     * @param UpdateCanvaMiniDisqAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCanvaMiniDisqAPIRequest $request)
    {
        $input = $request->all();

        /** @var CanvaMiniDisq $canvaMiniDisq */
        $canvaMiniDisq = $this->canvaMiniDisqRepository->find($id);

        if (empty($canvaMiniDisq)) {
            return $this->sendError('Canva Mini Disq not found');
        }

        $canvaMiniDisq = $this->canvaMiniDisqRepository->update($input, $id);

        return $this->sendResponse(new CanvaMiniDisqResource($canvaMiniDisq), 'CanvaMiniDisq updated successfully');
    }

    /**
     * Remove the specified CanvaMiniDisq from storage.
     * DELETE /canvaMiniDisqs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CanvaMiniDisq $canvaMiniDisq */
        $canvaMiniDisq = $this->canvaMiniDisqRepository->find($id);

        if (empty($canvaMiniDisq)) {
            return $this->sendError('Canva Mini Disq not found');
        }

        $canvaMiniDisq->delete();

        return $this->sendSuccess('Canva Mini Disq deleted successfully');
    }
}
