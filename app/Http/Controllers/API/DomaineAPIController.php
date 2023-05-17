<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDomaineAPIRequest;
use App\Http\Requests\API\UpdateDomaineAPIRequest;
use App\Models\Domaine;
use App\Repositories\DomaineRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DomaineResource;
use Response;

/**
 * Class DomaineController
 * @package App\Http\Controllers\API
 */

class DomaineAPIController extends AppBaseController
{
    /** @var  DomaineRepository */
    private $domaineRepository;

    public function __construct(DomaineRepository $domaineRepo)
    {
        $this->domaineRepository = $domaineRepo;
    }

    /**
     * Display a listing of the Domaine.
     * GET|HEAD /domaines
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $domaines = $this->domaineRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(DomaineResource::collection($domaines), 'Domaines retrieved successfully');
    }

    /**
     * Store a newly created Domaine in storage.
     * POST /domaines
     *
     * @param CreateDomaineAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDomaineAPIRequest $request)
    {
        $input = $request->all();

        $domaine = $this->domaineRepository->create($input);

        return $this->sendResponse(new DomaineResource($domaine), 'Domaine saved successfully');
    }

    /**
     * Display the specified Domaine.
     * GET|HEAD /domaines/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Domaine $domaine */
        $domaine = $this->domaineRepository->find($id);

        if (empty($domaine)) {
            return $this->sendError('Domaine not found');
        }

        return $this->sendResponse(new DomaineResource($domaine), 'Domaine retrieved successfully');
    }

    /**
     * Update the specified Domaine in storage.
     * PUT/PATCH /domaines/{id}
     *
     * @param int $id
     * @param UpdateDomaineAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDomaineAPIRequest $request)
    {
        $input = $request->all();

        /** @var Domaine $domaine */
        $domaine = $this->domaineRepository->find($id);

        if (empty($domaine)) {
            return $this->sendError('Domaine not found');
        }

        $domaine = $this->domaineRepository->update($input, $id);

        return $this->sendResponse(new DomaineResource($domaine), 'Domaine updated successfully');
    }

    /**
     * Remove the specified Domaine from storage.
     * DELETE /domaines/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Domaine $domaine */
        $domaine = $this->domaineRepository->find($id);

        if (empty($domaine)) {
            return $this->sendError('Domaine not found');
        }

        $domaine->delete();

        return $this->sendSuccess('Domaine deleted successfully');
    }
}
