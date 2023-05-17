<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCommentaireAPIRequest;
use App\Http\Requests\API\UpdateCommentaireAPIRequest;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use DB;

/**
 * Class CommentaireController
 * @package App\Http\Controllers\API
 */

class DynamicLinkController extends AppBaseController
{
    /**
     * Display a listing of the Commentaire.
     * GET|HEAD /commentaires
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Commentaire::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $commentaires = $query->get();

        return $this->sendResponse($commentaires->toArray(), 'Commentaires retrieved successfully');
    }

    /**
     * Store a newly created Commentaire in storage.
     * POST /commentaires
     *
     * @param CreateCommentaireAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentaireAPIRequest $request)
    {
        $token = $request->header('Authorization');
        $input = $request->all();

        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;

        /** @var Commentaire $commentaire */
        $commentaire = Commentaire::create($input);

        return $this->sendResponse($commentaire->toArray(), 'Commentaire saved successfully');
    }

    /**
     * Display the specified Commentaire.
     * GET|HEAD /commentaires/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Commentaire $commentaire */
        $commentaire = Commentaire::find($id);

        if (empty($commentaire)) {
            return $this->sendError('Commentaire not found');
        }

        return $this->sendResponse($commentaire->toArray(), 'Commentaire retrieved successfully');
    }

    /**
     * Update the specified Commentaire in storage.
     * PUT/PATCH /commentaires/{id}
     *
     * @param int $id
     * @param UpdateCommentaireAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCommentaireAPIRequest $request)
    {
        /** @var Commentaire $commentaire */
        $commentaire = Commentaire::find($id);

        if (empty($commentaire)) {
            return $this->sendError('Commentaire not found');
        }

        $commentaire->fill($request->all());
        $commentaire->save();

        return $this->sendResponse($commentaire->toArray(), 'Commentaire updated successfully');
    }

    /**
     * Remove the specified Commentaire from storage.
     * DELETE /commentaires/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Commentaire $commentaire */
        $commentaire = Commentaire::find($id);

        if (empty($commentaire)) {
            return $this->sendError('Commentaire not found');
        }

        $commentaire->delete();

        return $this->sendSuccess('Commentaire deleted successfully');
    }
}
