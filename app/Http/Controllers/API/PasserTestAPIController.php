<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePasserTestAPIRequest;
use App\Http\Requests\API\UpdatePasserTestAPIRequest;

use App\Models\PasserTest;
use App\Models\Question;
use App\Models\ResponseByUserDisc;
use App\Models\ResponseByUser;
use App\Models\QuestionQuizz;
use App\Models\ResponseUserQuizz;
use App\Models\QuestionChallenge;
use App\Models\ResponseUserChallenge;

use App\Repositories\PasserTestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PasserTestResource;
use Response;
use DB;

/**
 * Class PasserTestController
 * @package App\Http\Controllers\API
 */

class PasserTestAPIController extends AppBaseController
{
    /** @var  PasserTestRepository */
    private $passerTestRepository;

    public function __construct(PasserTestRepository $passerTestRepo)
    {
        $this->passerTestRepository = $passerTestRepo;
    }

    /**
     * Display a listing of the PasserTest.
     * GET|HEAD /passerTests
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $passerTests = $this->passerTestRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PasserTestResource::collection($passerTests), 'Passer Tests retrieved successfully');
    }

    /**
     * Store a newly created PasserTest in storage.
     * POST /passerTests
     *
     * @param CreatePasserTestAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePasserTestAPIRequest $request)
    {
        $input = $request->all();
        $token = $request->header('Authorization');
        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();
        $input['user_id'] = $user->user_id;

        $infos = array();
        $message = "";

        $passerTest = DB::table('passer_tests')
        ->select('passer_tests.id as passer_test_id', 'passer_tests.type', 'passer_tests.roue_de_vie_id', 'passer_tests.mini_disc_id',  'passer_tests.competence_id', 'passer_tests.quizz_id', 'passer_tests.challenge_id', 'passer_tests.point_id')
        ->where('type', $input['type'])
        ->where('user_id', $input['user_id'])
        ->orderBy('id', 'desc')
        ->first();
         
        if(empty($passerTest)){
            $test = $this->passerTestRepository->create($input);
            $passerTest = DB::table('passer_tests')
            ->select('passer_tests.id as passer_test_id', 'passer_tests.type', 'passer_tests.roue_de_vie_id', 'passer_tests.mini_disc_id',  'passer_tests.competence_id', 'passer_tests.quizz_id', 'passer_tests.challenge_id', 'passer_tests.point_id')
            ->where('passer_tests.id', $test->id)
            ->first();
        }

        if($input['type'] == 'mini_disq'){
            $out_of_question = Question::where('questions.type', 'mini_disq')->orderBy('id', 'asc')->get();
            $out_of = count($out_of_question);

            $step = ResponseByUserDisc::select('row')
                    ->where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passerTest->passer_test_id)
                    ->groupBy('row')
                    ->orderBy('row', 'desc')
                    ->get();

            foreach($out_of_question as $value){
                $check = ResponseByUserDisc::where('user_id', $input['user_id'])
                        ->where('passer_test_id', $passerTest->passer_test_id)
                        ->where('row', $value->id)
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
        }
        else if($input['type'] == 'roue_de_vie' || $input['type'] == 'competence'){
            $step = ResponseByUser::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passerTest->passer_test_id)
                    ->orderBy('id', 'desc')
                    ->get();

            if($input['type'] == 'roue_de_vie'){
                $out_of_question = Question::where('questions.type', 'roue_de_vie')->orderBy('id', 'asc')->get();
                $out_of = count($out_of_question);
            }else{
                $out_of_question = Question::where('questions.type', 'competence')->orderBy('id', 'asc')->get();
                $out_of = count($out_of_question);
            }

            foreach($out_of_question as $value){
                $check = ResponseByUser::where('user_id', $input['user_id'])
                        ->where('passer_test_id', $passerTest->passer_test_id)
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
        }
        else if($input['type'] == 'quizz'){
            $out_of_question = QuestionQuizz::where('quizz_id', $passerTest->quizz_id)->orderBy('id', 'asc')->get();
            $out_of = count($out_of_question);

            $step = ResponseUserQuizz::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passerTest->passer_test_id)
                    ->orderBy('id', 'desc')
                    ->get();

            foreach($out_of_question as $value){
                $check = ResponseUserQuizz::where('user_id', $input['user_id'])
                        ->where('passer_test_id', $passerTest->passer_test_id)
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
        }
        else if($input['type'] == 'challenge'){
            $out_of = QuestionChallenge::where('challenge_id', $passerTest->challenge_id)->count();

            $step = ResponseUserChallenge::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passerTest->passer_test_id)
                    ->orderBy('id', 'desc')
                    ->get();
            
            if(isset($step[0])){
                $steps = count($step);
                if($steps < $out_of)
                    $next_question = $step[0]->question_challenge_id + 1;
            }else
                $steps = 0;
        }

        $infos['informations'] = $passerTest; 
        $infos['step'] = $steps;
        $infos['out_of'] = $out_of; 

        if(!$steps)
            $message = "Test started successfully !";
        else if($steps > 0 && $steps < $out_of){
            $infos['next_question_id'] = $next_question;
            $message = "Resume your test ...";
        }else if($steps == $out_of)
            $message = "Test completed successfully !";

        return $this->sendResponse($infos, $message);
    }

    /**
     * Display the specified PasserTest.
     * GET|HEAD /passerTests/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PasserTest $passerTest */
        $passerTest = $this->passerTestRepository->find($id);

        if (empty($passerTest)) {
            return $this->sendError('Passer Test not found');
        }

        return $this->sendResponse(new PasserTestResource($passerTest), 'Passer Test retrieved successfully');
    }

    /**
     * Update the specified PasserTest in storage.
     * PUT/PATCH /passerTests/{id}
     *
     * @param int $id
     * @param UpdatePasserTestAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePasserTestAPIRequest $request)
    {
        $input = $request->all();

        /** @var PasserTest $passerTest */
        $passerTest = $this->passerTestRepository->find($id);

        if (empty($passerTest)) {
            return $this->sendError('Passer Test not found');
        }

        $passerTest = $this->passerTestRepository->update($input, $id);

        return $this->sendResponse(new PasserTestResource($passerTest), 'PasserTest updated successfully');
    }

    /**
     * Remove the specified PasserTest from storage.
     * DELETE /passerTests/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PasserTest $passerTest */
        $passerTest = $this->passerTestRepository->find($id);

        if (empty($passerTest)) {
            return $this->sendError('Passer Test not found');
        }

        $passerTest->delete();

        return $this->sendSuccess('Passer Test deleted successfully');
    }
}
