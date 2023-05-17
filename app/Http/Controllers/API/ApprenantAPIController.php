<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateApprenantAPIRequest;
use App\Http\Requests\API\UpdateApprenantAPIRequest;
use App\Models\Apprenant;
use App\Repositories\ApprenantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ApprenantResource;
use Response;

/**
 * Class ApprenantController
 * @package App\Http\Controllers\API
 */

class ApprenantAPIController extends AppBaseController
{
    /** @var  ApprenantRepository */
    private $apprenantRepository;

    public function __construct(ApprenantRepository $apprenantRepo)
    {
        $this->apprenantRepository = $apprenantRepo;
    }

    /**
     * Display a listing of the Apprenant.
     * GET|HEAD /apprenants
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $apprenants = $this->apprenantRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ApprenantResource::collection($apprenants), 'Apprenants retrieved successfully');
    }

    /**
     * Store a newly created Apprenant in storage.
     * POST /apprenants
     *
     * @param CreateApprenantAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateApprenantAPIRequest $request)
    {
        $input = $request->all();

        $apprenant = $this->apprenantRepository->create($input);

        return $this->sendResponse(new ApprenantResource($apprenant), 'Apprenant saved successfully');
    }

    /**
     * Display the specified Apprenant.
     * GET|HEAD /apprenants/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Apprenant $apprenant */
        $apprenant = $this->apprenantRepository->find($id);

        if (empty($apprenant)) {
            return $this->sendError('Apprenant not found');
        }

        return $this->sendResponse(new ApprenantResource($apprenant), 'Apprenant retrieved successfully');
    }

    /**
     * Update the specified Apprenant in storage.
     * PUT/PATCH /apprenants/{id}
     *
     * @param int $id
     * @param UpdateApprenantAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprenantAPIRequest $request)
    {
        $input = $request->all();

        /** @var Apprenant $apprenant */
        $apprenant = $this->apprenantRepository->find($id);

        if (empty($apprenant)) {
            return $this->sendError('Apprenant not found');
        }

        $apprenant = $this->apprenantRepository->update($input, $id);

        return $this->sendResponse(new ApprenantResource($apprenant), 'Apprenant updated successfully');
    }

    /**
     * Remove the specified Apprenant from storage.
     * DELETE /apprenants/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Apprenant $apprenant */
        $apprenant = $this->apprenantRepository->find($id);

        if (empty($apprenant)) {
            return $this->sendError('Apprenant not found');
        }

        $apprenant->delete();

        return $this->sendSuccess('Apprenant deleted successfully');
    }
}
