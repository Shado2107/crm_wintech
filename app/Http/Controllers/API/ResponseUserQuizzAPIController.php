<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponseUserQuizzAPIRequest;
use App\Http\Requests\API\UpdateResponseUserQuizzAPIRequest;
use App\Http\Requests\API\DomaineAPIRequest;

use App\Models\ResponseUserQuizz;
use App\Models\ResponsesQuizz;
use App\Models\QuestionQuizz;
use App\Models\PasserTest;
use App\Models\Points;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use DB;

/**
 * Class ResponseUserQuizzController
 * @package App\Http\Controllers\API
 */

class ResponseUserQuizzAPIController extends AppBaseController
{
    /**
     * Display a listing of the ResponseUserQuizz.
     * GET|HEAD /responseUserQuizzs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ResponseUserQuizz::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $responseUserQuizzs = $query->get();

        return $this->sendResponse($responseUserQuizzs->toArray(), 'Response User Quizzs retrieved successfully');
    }

    /**
     * Store a newly created ResponseUserQuizz in storage.
     * POST /responseUserQuizzs
     *
     * @param CreateResponseUserQuizzAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResponseUserQuizzAPIRequest $request)
    {
        $token = $request->header('Authorization');
        $input = $request->all();
        $infos = array();

        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;

        //Question quizz exists 
        $question = QuestionQuizz::find($input['question_quizz_id']);
        if(empty($question))
            return $this->sendError('Question not found !');

        //Workflow Test : Passer Test exists
        $passer_test = PasserTest::find($input['passer_test_id']);
        if(empty($passer_test) || $passer_test->type != 'quizz')
            return $this->sendError('Something went wrong : "id_passer_test" !');
        
        //Responses choosen exists 
        $reponses = ResponsesQuizz::find($input['response_quizz_id']);
        if(empty($reponses))
            return $this->sendError('Response ID not matches with any records !');

        $bool = false;
        $responses = ResponsesQuizz::where('question_quizz_id', $input['question_quizz_id'])->get();
        foreach($responses as $response)
            if($response->id == $input['response_quizz_id']){
                $bool = true;
                break;
            }

        if(!$bool)
            return $this->sendError('Something went wrong : "response_quizz_id" !');

        //No redundance on question for each row
        $redundance = ResponseUserQuizz::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $input['passer_test_id'])
                    ->where('question_quizz_id', $input['question_quizz_id'])
                    ->first();

        if($redundance)
            DB::table('response_user_quizzs')
            ->where('id', $redundance->id)
            ->update($input);
        else
            $responseUserQuizz = ResponseUserQuizz::create($input);
        
        $response = ResponsesQuizz::select('bonne_reponse')
                                    ->where('id', $input['response_quizz_id'])
                                    ->first();
        $infos['correct_response'] = $response->bonne_reponse;

        //Score
        $redundance_points = PasserTest::where('user_id', $input['user_id'])
                            ->where('type', 'quizz')
                            ->where('quizz_id', $question->quizz_id)
                            ->whereNotNull('point_id')
                            ->first();

        $correct_response = DB::table('response_user_quizzs')
        ->select('question_quizzs.libelle as question', 'responses_quizzs.valeur', 'responses_quizzs.bonne_reponse as state')
        ->join('question_quizzs', 'response_user_quizzs.question_quizz_id', 'question_quizzs.id')
        ->join('responses_quizzs', 'response_user_quizzs.response_quizz_id', 'responses_quizzs.id')
        ->where('user_id', $input['user_id'])
        ->where('passer_test_id', $input['passer_test_id'])
        ->where('responses_quizzs.bonne_reponse', 1)
        ->get();


        $questions = DB::table('question_quizzs')
        ->where('quizz_id', $passer_test->quizz_id)
        ->get();

        if(count($questions)){
            $stats = (count($correct_response) / count($questions)) * 100;
            $stats = round($stats);
        }
        
        if(empty($redundance_points) && $stats == 100){
            $point = Points::create(array(
            'value' => 15,
            'user_id'=> $input['user_id']
            ));

            $input['point_id'] = $point->id;
            $passer_test->fill($input);
            $passer_test->save();
        }

        $score = DB::table('points')
            ->where('user_id', $input['user_id'])
            ->sum('points.value');

        //Stages
        $out_of_question = QuestionQuizz::where('quizz_id', $passer_test->quizz_id)->orderBy('id', 'asc')->get();
        $out_of = count($out_of_question);

        $step = ResponseUserQuizz::where('user_id', $input['user_id'])
                ->where('passer_test_id', $passer_test->id)
                ->orderBy('id', 'desc')
                ->get();

        foreach($out_of_question as $value){
            $check = ResponseUserQuizz::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passer_test->id)
                    ->where('question_quizz_id', $value->id)
                    ->orderBy('id', 'desc')
                    ->get();
            
            if(!isset($check[0])){
                $next_question = $value->id;
                break;
            }
        }

        if(isset($step[0]))
            $steps = count($step);
        else
            $steps = 0;

        $infos['step'] = $steps;
        $infos['out_of'] = $out_of; 

        if($steps)
            if($steps > 0 && $steps < $out_of)
                $infos['next_question_id'] = $next_question;
            else{
                $infos['good_response_quizz'] = $stats . '%';
                $infos['score'] = $score;
            }

        return $this->sendResponse($infos, 'Response User Quizz saved successfully');
    }

    /**
     * Display the specified ResponseUserQuizz.
     * GET|HEAD /responseUserQuizzs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ResponseUserQuizz $responseUserQuizz */
        $responseUserQuizz = ResponseUserQuizz::find($id);

        if (empty($responseUserQuizz)) {
            return $this->sendError('Response User Quizz not found');
        }

        return $this->sendResponse($responseUserQuizz->toArray(), 'Response User Quizz retrieved successfully');
    }

    /**
     * Update the specified ResponseUserQuizz in storage.
     * PUT/PATCH /responseUserQuizzs/{id}
     *
     * @param int $id
     * @param UpdateResponseUserQuizzAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResponseUserQuizzAPIRequest $request)
    {
        /** @var ResponseUserQuizz $responseUserQuizz */
        $responseUserQuizz = ResponseUserQuizz::find($id);

        if (empty($responseUserQuizz)) {
            return $this->sendError('Response User Quizz not found');
        }

        $responseUserQuizz->fill($request->all());
        $responseUserQuizz->save();

        return $this->sendResponse($responseUserQuizz->toArray(), 'ResponseUserQuizz updated successfully');
    }

    /**
     * Remove the specified ResponseUserQuizz from storage.
     * DELETE /responseUserQuizzs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ResponseUserQuizz $responseUserQuizz */
        $responseUserQuizz = ResponseUserQuizz::find($id);

        if (empty($responseUserQuizz)) {
            return $this->sendError('Response User Quizz not found');
        }

        $responseUserQuizz->delete();

        return $this->sendSuccess('Response User Quizz deleted successfully');
    }

    public function stats(DomaineAPIRequest $request){
        $token = $request->header('Authorization');
        $input = $request->all();

        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;
        $score = 0;

        //Workflow Test : Passer Test exists
        $passer_test = PasserTest::find($input['passer_test_id']);
        if(empty($passer_test) || $passer_test->type != 'quizz')
            return $this->sendError('Something went wrong : "id_passer_test" !');

        //No redundance on question for each row
        $responses_user = DB::table('response_user_quizzs')
                        ->select('question_quizzs.libelle as question', 'responses_quizzs.valeur', 'responses_quizzs.bonne_reponse as state')
                        ->join('question_quizzs', 'response_user_quizzs.question_quizz_id', 'question_quizzs.id')
                        ->join('responses_quizzs', 'response_user_quizzs.response_quizz_id', 'responses_quizzs.id')
                        ->where('user_id', $input['user_id'])
                        ->where('passer_test_id', $input['passer_test_id'])
                        ->get();
        
        $correct_response = DB::table('response_user_quizzs')
        ->select('question_quizzs.libelle as question', 'responses_quizzs.valeur', 'responses_quizzs.bonne_reponse as state')
        ->join('question_quizzs', 'response_user_quizzs.question_quizz_id', 'question_quizzs.id')
        ->join('responses_quizzs', 'response_user_quizzs.response_quizz_id', 'responses_quizzs.id')
        ->where('user_id', $input['user_id'])
        ->where('passer_test_id', $input['passer_test_id'])
        ->where('responses_quizzs.bonne_reponse', 1)
        ->get();

        $questions = DB::table('question_quizzs')
        ->where('quizz_id', $passer_test->quizz_id)
        ->get();

        if(count($questions)){
            $score = (count($correct_response) / count($questions)) * 100;
            $score = round($score);
        }
        
        return $this->sendResponse($responses_user, "Quizz stats displayed successfully \n Your score is : " . $score . "% ! ");

    }
}
