<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateParcoursFormationAPIRequest;
use App\Http\Requests\API\UpdateParcoursFormationAPIRequest;

use App\Models\Parcours_formation;
use App\Models\Video;
use App\Models\Audio;
use App\Models\Article;
use App\Models\Challenge;
use App\Models\Citation;
use App\Models\Commentaire;
use App\Models\PasserTest;


use Illuminate\Contracts\Filesystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Storage;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use DB;

/**
 * Class ParcoursFormationController
 * @package App\Http\Controllers\API
 */

class ParcoursFormationAPIController extends AppBaseController
{
    /**
     * Display a listing of the ParcoursFormation.
     * GET|HEAD /parcoursFormations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $parcours_formation =  DB::table('parcours_formations')
        ->select('parcours_formations.id', 'parcours_formations.libelle as titre', 'parcours_formations.prix', 'users.avatar as avatar_formateur')
        ->join('formateurs', 'formateurs.id', 'parcours_formations.formateur_id')
        ->join('users', 'users.id', 'formateurs.user_id')
        ->take(3)
        ->get();

        return $this->sendResponse($parcours_formation, 'Parcours Formations retrieved successfully');
    }

    /**
     * Store a newly created ParcoursFormation in storage.
     * POST /parcoursFormations
     *
     * @param CreateParcoursFormationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateParcoursFormationAPIRequest $request)
    {
        $input = $request->all();

        /** @var ParcoursFormation $parcoursFormation */
        $parcoursFormation = Parcours_formation::create($input);

        return $this->sendResponse($parcoursFormation->toArray(), 'Parcours Formation saved successfully');
    }

    /**
     * Display the specified ParcoursFormation.
     * GET|HEAD /parcoursFormations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request, $id)
    {
        /** @var ParcoursFormation $parcoursFormation */
        $parcours = Parcours_formation::find($id);

        if (empty($parcours)) {
            return $this->sendError('Parcours Formation not found');
        }

        $token = $request->header('Authorization');
        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $infos = array();

        $types = array();
        $videos = array();
        $videos_object = array();
        $audios = array();
        $audios_object = array();
        $articles = array();
        $articles_object = array();
        $challenges = array();
        $citations_object = array();

        $infos['parcours'] =  DB::table('parcours_formations')
        ->select('parcours_formations.libelle as titre', 'parcours_formations.prix', 'parcours_formations.duree', 'users.nom as nom_formateur', 'users.prenom as prenom_formateur', 'users.avatar as avatar_formateur', 'parcours_formations.win_points', 'parcours_formations.require_credits')
        ->join('formateurs', 'formateurs.id', 'parcours_formations.formateur_id')
        ->join('users', 'users.id', 'formateurs.user_id')
        ->where('parcours_formations.id', $parcours->id)
        ->first();
        $infos['parcours']->avatar_formateur = Storage::disk('s3')->url('users/'. $infos['parcours']->avatar_formateur); 

        //Videos
        $raw_videos = Video::select('id', 'libelle', 'description', 'source', 'created_at', 'updated_at', 'quizz_id')
                      ->where('parcours_formation_id', $parcours->id)
                      ->get();
        $score = 0;
        foreach($raw_videos as $video){
            $video->source_url = Storage::disk('s3')->url('activities/videos/'. $video->source);
            $passer_test = PasserTest::where('quizz_id', $video->quizz_id)->where('user_id', $user->user_id)->whereNotNull('point_id')->first();
            if(!empty($passer_test))
                $score += 1;
            array_push($videos, $video);
        }
        $pourcentage_video = ($score / 3) * 100;

        //Audios
        $raw_audios = Audio::select('id', 'libelle', 'description', 'podcast', 'created_at', 'updated_at', 'quizz_id as quizz')
                      ->where('parcours_formation_id', $parcours->id)
                      ->get();
        $score = 0;
        foreach($raw_audios as $audio){
            $audio->podcast_url = Storage::disk('s3')->url('activities/audios/'. $audio->podcast);
            $passer_test = PasserTest::where('quizz_id', $audio->quizz_id)->where('user_id', $user->user_id)->whereNotNull('point_id')->first();
            if(!empty($passer_test))
                $score += 1;
            array_push($audios, $audio);
        }
        $pourcentage_audio = ($score / 3) * 100;

        //Articles
        $raw_articles = Article::select('id', 'libelle', 'content', 'link', 'created_at', 'updated_at', 'quizz_id as quizz')
                        ->where('parcours_formation_id', $parcours->id)
                        ->get();
        $score = 0;
        foreach($raw_articles as $article){
            $passer_test = PasserTest::where('quizz_id', $article->quizz_id)->where('user_id', $user->user_id)->whereNotNull('point_id')->first();
            if(!empty($passer_test))
                $score += 1;
            array_push($articles, $article);
        }
        $pourcentage_article = ($score / 3) * 100;

        //Challenges
        $raw_challenges = Challenge::select('id', 'title', 'type', 'created_at', 'updated_at')
                        ->where('parcours_formation_id', $parcours->id)
                        ->get();
        foreach($raw_challenges as $challenge){
            $questions = DB::table('question_challenges')
                        ->select('question_challenges.id', 'question_challenges.libelle')
                        ->where('question_challenges.challenge_id', $challenge->id)
                        ->get();
            $challenge->questions = $questions;
            array_push($challenges, $challenge);
        }

        //Citations
        $citations = Citation::select('id', 'content', 'name_author', 'created_at', 'updated_at')
                    ->where('parcours_formation_id', $parcours->id)
                    ->get();

        $pourcentage = 0;
        if(isset($raw_videos[0])){
            array_push($types, 'Videos');
            $pourcentage += $pourcentage_video;
            $videos_object['pourcentage'] = $pourcentage_video;
            $videos_object['videos_list'] = $videos;
            $infos['videos'] = $videos_object;
        }
        if(isset($raw_audios[0])){
            array_push($types, 'Audios');
            $pourcentage += $pourcentage_audio;
            $audios_object['pourcentage'] = $pourcentage_audio;
            $audios_object['audios_list'] = $audios;
            $infos['audios'] = $audios_object;
        }
        if(isset($raw_articles[0])){
            array_push($types, 'Articles');
            $pourcentage += $pourcentage_article;
            $articles_object['pourcentage'] = $pourcentage_article;
            $articles_object['articles_list'] = $articles;
            $infos['articles'] = $articles_object;
        }
        if(isset($citations[0])){
            array_push($types, 'Citations');
            $citations_object['citations_list'] = $citations;
            $infos['citations'] = $citations_object;
        }
        if(isset($raw_challenges[0])){
            array_push($types, 'Challenges');
            $infos['challenges'] = $challenges;
        }

        $infos['pourcentage'] = $pourcentage / (count($types) - 2);
        
        $infos['types'] = $types;

        return $this->sendResponse($infos, 'Parcours Formation retrieved successfully');
    }

    /**
     * Update the specified ParcoursFormation in storage.
     * PUT/PATCH /parcoursFormations/{id}
     *
     * @param int $id
     * @param UpdateParcoursFormationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParcoursFormationAPIRequest $request)
    {
        /** @var ParcoursFormation $parcoursFormation */
        $parcoursFormation = Parcours_formation::find($id);

        if (empty($parcoursFormation)) {
            return $this->sendError('Parcours Formation not found');
        }

        $parcoursFormation->fill($request->all());
        $parcoursFormation->save();

        return $this->sendResponse($parcoursFormation->toArray(), 'ParcoursFormation updated successfully');
    }

    /**
     * Remove the specified ParcoursFormation from storage.
     * DELETE /parcoursFormations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ParcoursFormation $parcoursFormation */
        $parcoursFormation = Parcours_formation::find($id);

        if (empty($parcoursFormation)) {
            return $this->sendError('Parcours Formation not found');
        }

        $parcoursFormation->delete();

        return $this->sendSuccess('Parcours Formation deleted successfully');
    }
}
