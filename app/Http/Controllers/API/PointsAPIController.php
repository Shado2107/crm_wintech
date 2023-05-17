<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePointsAPIRequest;
use App\Http\Requests\API\UpdatePointsAPIRequest;
use App\Models\Points;
use App\Models\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use DB;

/**
 * Class PointsController
 * @package App\Http\Controllers\API
 */

class PointsAPIController extends AppBaseController
{
    /**
     * Display a listing of the Points.
     * GET|HEAD /points
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Points::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $points = $query->get();

        return $this->sendResponse($points->toArray(), 'Points retrieved successfully');
    }

    /**
     * Store a newly created Points in storage.
     * POST /points
     *
     * @param CreatePointsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePointsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Points $points */
        $points = Points::create($input);

        return $this->sendResponse($points->toArray(), 'Points saved successfully');
    }

    /**
     * Display the specified Points.
     * GET|HEAD /points/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Points $points */
        $points = Points::find($id);

        if (empty($points)) {
            return $this->sendError('Points not found');
        }

        return $this->sendResponse($points->toArray(), 'Points retrieved successfully');
    }

    /**
     * Update the specified Points in storage.
     * PUT/PATCH /points/{id}
     *
     * @param int $id
     * @param UpdatePointsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePointsAPIRequest $request)
    {
        /** @var Points $points */
        $points = Points::find($id);

        if (empty($points)) {
            return $this->sendError('Points not found');
        }

        $points->fill($request->all());
        $points->save();

        return $this->sendResponse($points->toArray(), 'Points updated successfully');
    }

    /**
     * Remove the specified Points from storage.
     * DELETE /points/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Points $points */
        $points = Points::find($id);

        if (empty($points)) {
            return $this->sendError('Points not found');
        }

        $points->delete();

        return $this->sendSuccess('Points deleted successfully');
    }

    public function profile_points(Request $request){
        $token = $request->header('Authorization');
        $infos = array();
        $users = array();

        $user_token = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $infos = array();

        $infos['points'] = DB::table('points')
                ->where('user_id', $user_token->user_id)
                ->sum('points.value');

        $rankings = DB::table('points')
                ->select(DB::raw('sum(value) as points, user_id ,users.nom, users.prenom'))
                ->join('users', 'users.id', 'points.user_id')
                ->groupBy('user_id', 'nom', 'prenom')
                ->orderBy('points', 'DESC')
                ->get();
        $i = 1;  
        foreach ($rankings as $ranking) {
            if($ranking->user_id == $user_token->user_id){
                $infos['rank'] = $i;
                break;
            }
            $i+=1;
        }

        $infos['rankings'] = $rankings;

        return $this->sendResponse($infos, 'All about points !');
        
    }
}
