<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAudioAPIRequest;
use App\Http\Requests\API\UpdateAudioAPIRequest;

use App\Models\Audio;
use App\Models\Commentaire;
use App\Models\PasserTest;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use Storage;
use DB;

/**
 * Class AudioController
 * @package App\Http\Controllers\API
 */

class AudioAPIController extends AppBaseController
{
    /**
     * Display a listing of the Audio.
     * GET|HEAD /audio
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Audio::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $audio = $query->get();

        return $this->sendResponse($audio->toArray(), 'Audio retrieved successfully');
    }

    /**
     * Store a newly created Audio in storage.
     * POST /audio
     *
     * @param CreateAudioAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAudioAPIRequest $request)
    {
        $input = $request->all();

        /** @var Audio $audio */
        $audio = Audio::create($input);

        return $this->sendResponse($audio->toArray(), 'Audio saved successfully');
    }

    /**
     * Display the specified Audio.
     * GET|HEAD /audio/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request, $id)
    {
        /** @var Audio $audio */
        $audio = Audio::find($id);

        if (empty($audio)) 
            return $this->sendError('Audio not found');
        
        $formateur = DB::table('audios')
                    ->select('users.nom', 'users.prenom')
                    ->join('parcours_formations', 'parcours_formations.id', 'audios.parcours_formation_id')
                    ->join('formateurs', 'formateurs.id', 'parcours_formations.formateur_id')
                    ->join('users', 'users.id', 'formateurs.user_id')
                    ->first();

        //Nom & Prenom formateur
        $audio->nom_formateur = $formateur->nom;
        $audio->prenom_formateur = $formateur->prenom;

        $token = $request->header('Authorization');
        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $passer_test = PasserTest::where('quizz_id', $audio->quizz_id)->where('user_id', $user->user_id)->whereNotNull('point_id')->first();

        //Get the quizzes 
        $quizzs = array();
        $raw_quizzs = DB::table('quizzs')
                ->select('question_quizzs.id', 'quizzs.title', 'question_quizzs.libelle')
                ->join('question_quizzs', 'question_quizzs.quizz_id', 'quizzs.id')
                ->where('quizzs.id', $audio->quizz_id)
                ->get();

        $score = 0;
        foreach($raw_quizzs as $quizz){
            $responses = DB::table('question_quizzs')
                        ->select('responses_quizzs.id', 'responses_quizzs.valeur', 'responses_quizzs.bonne_reponse as correct_response')
                        ->join('responses_quizzs', 'responses_quizzs.question_quizz_id', 'question_quizzs.id')
                        ->where('question_quizzs.id', $quizz->id)
                        ->get();
            $quizz->responses = $responses;
            array_push($quizzs, $quizz);
        }

        $audio->pourcentage = 0;
        if(!empty($passer_test))
            $audio->pourcentage = 100;

        $audio->quizz_id = $audio->quizz;
        $audio->quizz = $quizzs;

        $audio->podcast_url = Storage::disk('s3')->url('activities/audios/'. $audio->podcast);
        

        //Get comments
        $comments = Commentaire::select('text', 'user_id', 'created_at', 'updated_at')->where('audio_id', $audio->id)->get();
        if(!empty($comments))
            $audio->comments = $comments;
      
        return $this->sendResponse($audio, 'Audio retrieved successfully');
    }

    /**
     * Update the specified Audio in storage.
     * PUT/PATCH /audio/{id}
     *
     * @param int $id
     * @param UpdateAudioAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAudioAPIRequest $request)
    {
        /** @var Audio $audio */
        $audio = Audio::find($id);

        if (empty($audio)) {
            return $this->sendError('Audio not found');
        }

        $audio->fill($request->all());
        $audio->save();

        return $this->sendResponse($audio->toArray(), 'Audio updated successfully');
    }

    /**
     * Remove the specified Audio from storage.
     * DELETE /audio/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Audio $audio */
        $audio = Audio::find($id);

        if (empty($audio)) {
            return $this->sendError('Audio not found');
        }

        $audio->delete();

        return $this->sendSuccess('Audio deleted successfully');
    }
}
