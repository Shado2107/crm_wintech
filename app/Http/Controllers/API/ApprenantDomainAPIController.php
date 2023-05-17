<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateApprenantDomainAPIRequest;
use App\Http\Requests\API\UpdateApprenantDomainAPIRequest;
use App\Models\ApprenantDomain;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ApprenantDomainController
 * @package App\Http\Controllers\API
 */

class ApprenantDomainAPIController extends AppBaseController
{
    /**
     * Display a listing of the ApprenantDomain.
     * GET|HEAD /apprenantDomains
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ApprenantDomain::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $apprenantDomains = $query->get();

        return $this->sendResponse($apprenantDomains->toArray(), 'Apprenant Domains retrieved successfully');
    }

    /**
     * Store a newly created ApprenantDomain in storage.
     * POST /apprenantDomains
     *
     * @param CreateApprenantDomainAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateApprenantDomainAPIRequest $request)
    {
        $input = $request->all();

        /** @var ApprenantDomain $apprenantDomain */
        $apprenantDomain = ApprenantDomain::create($input);

        return $this->sendResponse($apprenantDomain->toArray(), 'Apprenant Domain saved successfully');
    }

    /**
     * Display the specified ApprenantDomain.
     * GET|HEAD /apprenantDomains/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ApprenantDomain $apprenantDomain */
        $apprenantDomain = ApprenantDomain::find($id);

        if (empty($apprenantDomain)) {
            return $this->sendError('Apprenant Domain not found');
        }

        return $this->sendResponse($apprenantDomain->toArray(), 'Apprenant Domain retrieved successfully');
    }

    /**
     * Update the specified ApprenantDomain in storage.
     * PUT/PATCH /apprenantDomains/{id}
     *
     * @param int $id
     * @param UpdateApprenantDomainAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprenantDomainAPIRequest $request)
    {
        /** @var ApprenantDomain $apprenantDomain */
        $apprenantDomain = ApprenantDomain::find($id);

        if (empty($apprenantDomain)) {
            return $this->sendError('Apprenant Domain not found');
        }

        $apprenantDomain->fill($request->all());
        $apprenantDomain->save();

        return $this->sendResponse($apprenantDomain->toArray(), 'ApprenantDomain updated successfully');
    }

    /**
     * Remove the specified ApprenantDomain from storage.
     * DELETE /apprenantDomains/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ApprenantDomain $apprenantDomain */
        $apprenantDomain = ApprenantDomain::find($id);

        if (empty($apprenantDomain)) {
            return $this->sendError('Apprenant Domain not found');
        }

        $apprenantDomain->delete();

        return $this->sendSuccess('Apprenant Domain deleted successfully');
    }
}
