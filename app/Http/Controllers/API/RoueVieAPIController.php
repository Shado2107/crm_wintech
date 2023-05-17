<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRoueVieAPIRequest;
use App\Http\Requests\API\UpdateRoueVieAPIRequest;
use App\Models\RoueVie;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RoueVieController
 * @package App\Http\Controllers\API
 */

class RoueVieAPIController extends AppBaseController
{
    /**
     * Display a listing of the RoueVie.
     * GET|HEAD /roueVies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = RoueVie::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $roueVies = $query->get();

        return $this->sendResponse($roueVies->toArray(), 'Roue Vies retrieved successfully');
    }

    /**
     * Store a newly created RoueVie in storage.
     * POST /roueVies
     *
     * @param CreateRoueVieAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRoueVieAPIRequest $request)
    {
        $input = $request->all();

        /** @var RoueVie $roueVie */
        $roueVie = RoueVie::create($input);

        return $this->sendResponse($roueVie->toArray(), 'Roue Vie saved successfully');
    }

    /**
     * Display the specified RoueVie.
     * GET|HEAD /roueVies/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RoueVie $roueVie */
        $roueVie = RoueVie::find($id);

        if (empty($roueVie)) {
            return $this->sendError('Roue Vie not found');
        }

        return $this->sendResponse($roueVie->toArray(), 'Roue Vie retrieved successfully');
    }

    /**
     * Update the specified RoueVie in storage.
     * PUT/PATCH /roueVies/{id}
     *
     * @param int $id
     * @param UpdateRoueVieAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoueVieAPIRequest $request)
    {
        /** @var RoueVie $roueVie */
        $roueVie = RoueVie::find($id);

        if (empty($roueVie)) {
            return $this->sendError('Roue Vie not found');
        }

        $roueVie->fill($request->all());
        $roueVie->save();

        return $this->sendResponse($roueVie->toArray(), 'RoueVie updated successfully');
    }

    /**
     * Remove the specified RoueVie from storage.
     * DELETE /roueVies/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RoueVie $roueVie */
        $roueVie = RoueVie::find($id);

        if (empty($roueVie)) {
            return $this->sendError('Roue Vie not found');
        }

        $roueVie->delete();

        return $this->sendSuccess('Roue Vie deleted successfully');
    }
}
