<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVideoAPIRequest;
use App\Http\Requests\API\UpdateVideoAPIRequest;

use App\Models\Video;
use App\Models\Commentaire;
use App\Models\PasserTest;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use Storage;
use DB;

/**
 * Class VideoController
 * @package App\Http\Controllers\API
 */

class VideoAPIController extends AppBaseController
{
    /**
     * Display a listing of the Video.
     * GET|HEAD /videos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Video::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $videos = $query->get();

        return $this->sendResponse($videos->toArray(), 'Videos retrieved successfully');
    }

    /**
     * Store a newly created Video in storage.
     * POST /videos
     *
     * @param CreateVideoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVideoAPIRequest $request)
    {
        $input = $request->all();

        /** @var Video $video */
        $video = Video::create($input);

        return $this->sendResponse($video->toArray(), 'Video saved successfully');
    }

    /**
     * Display the specified Video.
     * GET|HEAD /videos/{id}
     *
     * @param int $id
     *
     * @return Response
     */

    public function show(Request $request, $id)
    {
        /** @var Video $video */
        $video = Video::find($id);

        if(empty($video)) 
            return $this->sendError('Video not found');
        
        $token = $request->header('Authorization');
        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $passer_test = PasserTest::where('quizz_id', $video->quizz_id)->where('user_id', $user->user_id)->whereNotNull('point_id')->first();
        
        //Get the quizzes 
        $quizzs = array();

        $raw_quizzs = DB::table('quizzs')
                        ->select('question_quizzs.id', 'quizzs.title', 'question_quizzs.libelle')
                        ->join('question_quizzs', 'question_quizzs.quizz_id', 'quizzs.id')
                        ->where('quizzs.id', $video->quizz_id)
                        ->get();
                        
        foreach($raw_quizzs as $quizz){
            $responses = DB::table('question_quizzs')
                            ->select('responses_quizzs.id', 'responses_quizzs.valeur', 'responses_quizzs.bonne_reponse as correct_response')
                            ->join('responses_quizzs', 'responses_quizzs.question_quizz_id', 'question_quizzs.id')
                            ->where('question_quizzs.id', $quizz->id)
                            ->get();
            $quizz->responses = $responses;
            array_push($quizzs, $quizz);
        }
        $video->pourcentage = 0;
        if(!empty($passer_test))
            $video->pourcentage = 100;

        $video->quizz_id = $video->quizz;
        $video->quizz = $quizzs;

        $video->source_url = Storage::disk('s3')->url('activities/videos/'. $video->source); 

        //Get comments
        $comments = Commentaire::select('text', 'user_id', 'created_at', 'updated_at')->where('video_id', $video->id)->get();
        if(!empty($comments))
            $video->comments = $comments;

        return $this->sendResponse($video, 'Parcours Formation retrieved successfully');
    }
    

    /**
     * Update the specified Video in storage.
     * PUT/PATCH /videos/{id}
     *
     * @param int $id
     * @param UpdateVideoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVideoAPIRequest $request)
    {
        /** @var Video $video */
        $video = Video::find($id);

        if (empty($video)) {
            return $this->sendError('Video not found');
        }

        $video->fill($request->all());
        $video->save();

        return $this->sendResponse($video->toArray(), 'Video updated successfully');
    }

    /**
     * Remove the specified Video from storage.
     * DELETE /videos/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Video $video */
        $video = Video::find($id);

        if (empty($video)) {
            return $this->sendError('Video not found');
        }

        $video->delete();

        return $this->sendSuccess('Video deleted successfully');
    }
}
