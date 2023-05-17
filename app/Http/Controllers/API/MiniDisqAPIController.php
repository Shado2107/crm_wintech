<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMiniDisqAPIRequest;
use App\Http\Requests\API\UpdateMiniDisqAPIRequest;
use App\Models\MiniDisq;
use App\Repositories\MiniDisqRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MiniDisqResource;
use Response;

/**
 * Class MiniDisqController
 * @package App\Http\Controllers\API
 */

class MiniDisqAPIController extends AppBaseController
{
    /** @var  MiniDisqRepository */
    private $miniDisqRepository;

    public function __construct(MiniDisqRepository $miniDisqRepo)
    {
        $this->miniDisqRepository = $miniDisqRepo;
    }

    /**
     * Display a listing of the MiniDisq.
     * GET|HEAD /miniDisqs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $miniDisqs = $this->miniDisqRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(MiniDisqResource::collection($miniDisqs), 'Mini Disqs retrieved successfully');
    }

    /**
     * Store a newly created MiniDisq in storage.
     * POST /miniDisqs
     *
     * @param CreateMiniDisqAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMiniDisqAPIRequest $request)
    {
        $input = $request->all();

        $miniDisq = $this->miniDisqRepository->create($input);

        return $this->sendResponse(new MiniDisqResource($miniDisq), 'Mini Disq saved successfully');
    }

    /**
     * Display the specified MiniDisq.
     * GET|HEAD /miniDisqs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MiniDisq $miniDisq */
        $miniDisq = $this->miniDisqRepository->find($id);

        if (empty($miniDisq)) {
            return $this->sendError('Mini Disq not found');
        }

        return $this->sendResponse(new MiniDisqResource($miniDisq), 'Mini Disq retrieved successfully');
    }

    /**
     * Update the specified MiniDisq in storage.
     * PUT/PATCH /miniDisqs/{id}
     *
     * @param int $id
     * @param UpdateMiniDisqAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMiniDisqAPIRequest $request)
    {
        $input = $request->all();

        /** @var MiniDisq $miniDisq */
        $miniDisq = $this->miniDisqRepository->find($id);

        if (empty($miniDisq)) {
            return $this->sendError('Mini Disq not found');
        }

        $miniDisq = $this->miniDisqRepository->update($input, $id);

        return $this->sendResponse(new MiniDisqResource($miniDisq), 'MiniDisq updated successfully');
    }

    /**
     * Remove the specified MiniDisq from storage.
     * DELETE /miniDisqs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MiniDisq $miniDisq */
        $miniDisq = $this->miniDisqRepository->find($id);

        if (empty($miniDisq)) {
            return $this->sendError('Mini Disq not found');
        }

        $miniDisq->delete();

        return $this->sendSuccess('Mini Disq deleted successfully');
    }
}
