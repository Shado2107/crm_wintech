<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponseByUserAPIRequest;
use App\Http\Requests\API\UpdateResponseByUserAPIRequest;
use App\Http\Requests\API\DomaineAPIRequest;
use App\Http\Requests\API\CreateApprenantDomainAPIRequest;

use App\Models\ResponseByUser;
use App\Models\Question;
use App\Models\PasserTest;
use App\Models\Domaine;
use App\Models\ApprenantDomain;
use App\Models\Apprenant;
use App\Models\Points;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use DB;

/**
 * Class ResponseByUserController
 * @package App\Http\Controllers\API
 */

class ResponseByUserAPIController extends AppBaseController
{
    /**
     * Display a listing of the ResponseByUser.
     * GET|HEAD /responseByUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ResponseByUser::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $responseByUsers = $query->get();

        return $this->sendResponse($responseByUsers->toArray(), 'Response By Users retrieved successfully');
    }

    /**
     * Store a newly created ResponseByUser in storage.
     * POST /responseByUsers
     *
     * @param CreateResponseByUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResponseByUserAPIRequest $request)
    {
        $token = $request->header('Authorization');
        $input = $request->all();

        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;

        //Workflow Test : Passer Test exists
        $passer_test = PasserTest::find($input['passer_test_id']);
        if(empty($passer_test) || ($passer_test->type != 'roue_de_vie' &&  $passer_test->type != 'competence' ) )
            return $this->sendError('Something went wrong : "id_passer_test" !');
        //Question exists 
        $question = Question::find($input['question_id']);
        if(empty($question))
            return $this->sendError('Question not found !');
        
        if($passer_test->type == 'roue_de_vie'){
            if($input['question_id'] < 11 || $input['question_id'] > 18)
                return $this->sendError('Question not applied !');
        }

        if($passer_test->type == 'competence'){
            if($input['question_id'] < 19 || $input['question_id'] > 30)
                return $this->sendError('Question not applied !');
        }

        $valuable = [1,2,3,4,5,6,7,8,9,10]; 
        if(!in_array($input['note'], $valuable))
            return $this->sendError('Only values till 10 are authorized !');

        //No redundance on question for each row
        $redundance = ResponseByUser::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $input['passer_test_id'])
                    ->where('question_id', $input['question_id'])
                    ->first();

        if($redundance)
            DB::table('response_by_users')
            ->where('id', $redundance->id)
            ->update($input);
        else
            $responseByUser = ResponseByUser::create($input);

        $step = ResponseByUser::where('user_id', $input['user_id'])
        ->where('passer_test_id', $passer_test->id)
        ->orderBy('id', 'desc')
        ->get();

        if($passer_test->type == 'roue_de_vie'){
            $out_of_question = Question::where('questions.type', 'roue_de_vie')->orderBy('id', 'asc')->get();
            $out_of = count($out_of_question);
        }else{
            $out_of_question = Question::where('questions.type', 'competence')->orderBy('id', 'asc')->get();
            $out_of = count($out_of_question);
        }

        foreach($out_of_question as $value){
            $check = ResponseByUser::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passer_test->id)
                    ->where('question_id', $value->id)
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

        if(isset($next_question))
            $infos['next_question'] = $next_question;

        return $this->sendResponse($infos, 'Response By User saved successfully !');
    }

    /**
     * Display the specified ResponseByUser.
     * GET|HEAD /responseByUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ResponseByUser $responseByUser */
        $responseByUser = ResponseByUser::find($id);

        if (empty($responseByUser)) {
            return $this->sendError('Response By User not found');
        }

        return $this->sendResponse($responseByUser->toArray(), 'Response By User retrieved successfully');
    }

    /**
     * Update the specified ResponseByUser in storage.
     * PUT/PATCH /responseByUsers/{id}
     *
     * @param int $id
     * @param UpdateResponseByUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResponseByUserAPIRequest $request)
    {
        /** @var ResponseByUser $responseByUser */
        $responseByUser = ResponseByUser::find($id);

        if (empty($responseByUser)) {
            return $this->sendError('Response By User not found');
        }

        $responseByUser->fill($request->all());
        $responseByUser->save();

        return $this->sendResponse($responseByUser->toArray(), 'ResponseByUser updated successfully');
    }

    /**
     * Remove the specified ResponseByUser from storage.
     * DELETE /responseByUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ResponseByUser $responseByUser */
        $responseByUser = ResponseByUser::find($id);

        if (empty($responseByUser)) 
            return $this->sendError('Response By User not found !');

        $responseByUser->delete();

        return $this->sendSuccess('Response By User deleted successfully');
    }

    public function domaine_roue_vie(DomaineAPIRequest $request){
        $token = $request->header('Authorization');
        $input = $request->all();

        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;

        //Workflow Test : Passer Test exists
        $passer_test = PasserTest::find($input['passer_test_id']);
        if(empty($passer_test) || $passer_test->type != 'roue_de_vie')
            return $this->sendError('Something went wrong : "id_passer_test" !');
        
        $responses_user = DB::table('response_by_users')
                          ->select('domaines.id as domaine_id', 'domaines.libelle', 'response_by_users.note')
                          ->join('questions', 'questions.id', 'response_by_users.question_id')
                          ->join('domaines', 'domaines.id', 'questions.domaine_id')
                          ->where('user_id', $input['user_id'])
                          ->where('passer_test_id', $input['passer_test_id'])
                          ->where('response_by_users.note', '<', 10)
                          ->orderBy('response_by_users.note', 'asc')
                          ->get();
        
        if(empty($responses_user)) 
            return $this->sendError('No responses found !');
              
        return $this->sendResponse($responses_user, 'Domains displayed successfully !');
    }

    public function domaine_priorities(CreateApprenantDomainAPIRequest $request){
        $token = $request->header('Authorization');
        $input = $request->all();
        $infos = array();

        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;

        //Workflow Test : Passer Test exists
        $passer_test = PasserTest::find($input['passer_test_id']);
        if(empty($passer_test) || $passer_test->type != 'roue_de_vie')
            return $this->sendError('Something went wrong : "id_passer_test" !');
        
        //Apprenant found
        $apprenant = Apprenant::where('user_id', $input['user_id'])->first();
        if(empty($apprenant)) 
            return $this->sendError('No apprenant found !');
       
        $input['apprenant_id'] = $apprenant->id;

        //No redundance on question for each row
        $redundance = ApprenantDomain::select('domain_id')->where('apprenant_id', $input['apprenant_id'])->take(3)->get();

        if(isset($redundance[0]))
            return $this->sendResponse($redundance,'You already set your priorities domain !');
        
        $domains = explode(',' , $input['domains']);
        $selected = array();

        foreach ($domains as $key => $value) {
            if($key == 5)
                break;

            $domain = Domaine::find($value);
            if(empty($domain)) 
                return $this->sendError('No domain found !');

            $input['domain_id'] = $domain->id;
            
            ApprenantDomain::create($input);
            array_push($selected,$domain);
        }

        $redundance_points = PasserTest::where('user_id', $input['user_id'])
                            ->where('type', 'roue_de_vie')
                            ->whereNotNull('point_id')
                            ->first();

        if(!empty($redundance_points)){
            $point = Points::create(array(
                'value' => 10,
                'user_id'=> $input['user_id']
            ));

            $input['point_id'] = $point->id;
            $passer_test->fill($input);
            $passer_test->save();
        }

        $score = DB::table('points')
        ->where('user_id', $input['user_id'])
        ->sum('points.value');
        

        $infos['score'] = $score;
        $infos['domains'] = $selected;
              
        return $this->sendResponse($infos, 'Priorities domains selected successfully !');

    }

    public function competences(DomaineAPIRequest $request){
        $token = $request->header('Authorization');
        $input = $request->all();

        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;

        //Workflow Test : Passer Test exists
        $passer_test = PasserTest::find($input['passer_test_id']);
        if(empty($passer_test) || $passer_test->type != 'competence')
            return $this->sendError('Something went wrong : "id_passer_test" !');
        
        $responses_user = DB::table('response_by_users')
                          ->select('questions.libelle', 'response_by_users.note')
                          ->join('questions', 'questions.id', 'response_by_users.question_id')
                          ->where('user_id', $input['user_id'])
                          ->where('passer_test_id', $input['passer_test_id'])
                          ->orderBy('questions.id', 'asc')
                          ->get();
        
        if(empty($responses_user)) 
            return $this->sendError('No responses found !');
              
        return $this->sendResponse($responses_user, 'Competences displayed successfully !');
    }
}
