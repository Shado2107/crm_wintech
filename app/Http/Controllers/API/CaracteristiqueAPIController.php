<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaracteristiqueAPIRequest;
use App\Http\Requests\API\UpdateCaracteristiqueAPIRequest;
use App\Models\Caracteristique;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CaracteristiqueController
 * @package App\Http\Controllers\API
 */

class CaracteristiqueAPIController extends AppBaseController
{
    /**
     * Display a listing of the Caracteristique.
     * GET|HEAD /caracteristiques
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Caracteristique::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $caracteristiques = $query->get();

        return $this->sendResponse($caracteristiques->toArray(), 'Caracteristiques retrieved successfully');
    }

    /**
     * Store a newly created Caracteristique in storage.
     * POST /caracteristiques
     *
     * @param CreateCaracteristiqueAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCaracteristiqueAPIRequest $request)
    {
        $input = $request->all();

        /** @var Caracteristique $caracteristique */
        $caracteristique = Caracteristique::create($input);

        return $this->sendResponse($caracteristique->toArray(), 'Caracteristique saved successfully');
    }

    /**
     * Display the specified Caracteristique.
     * GET|HEAD /caracteristiques/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Caracteristique $caracteristique */
        $caracteristique = Caracteristique::find($id);

        if (empty($caracteristique)) {
            return $this->sendError('Caracteristique not found');
        }

        return $this->sendResponse($caracteristique->toArray(), 'Caracteristique retrieved successfully');
    }

    /**
     * Update the specified Caracteristique in storage.
     * PUT/PATCH /caracteristiques/{id}
     *
     * @param int $id
     * @param UpdateCaracteristiqueAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCaracteristiqueAPIRequest $request)
    {
        /** @var Caracteristique $caracteristique */
        $caracteristique = Caracteristique::find($id);

        if (empty($caracteristique)) {
            return $this->sendError('Caracteristique not found');
        }

        $caracteristique->fill($request->all());
        $caracteristique->save();

        return $this->sendResponse($caracteristique->toArray(), 'Caracteristique updated successfully');
    }

    /**
     * Remove the specified Caracteristique from storage.
     * DELETE /caracteristiques/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Caracteristique $caracteristique */
        $caracteristique = Caracteristique::find($id);

        if (empty($caracteristique)) {
            return $this->sendError('Caracteristique not found');
        }

        $caracteristique->delete();

        return $this->sendSuccess('Caracteristique deleted successfully');
    }
}
