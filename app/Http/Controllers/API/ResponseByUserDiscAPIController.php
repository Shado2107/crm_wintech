<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponseByUserDiscAPIRequest;
use App\Http\Requests\API\UpdateResponseByUserDiscAPIRequest;
use App\Http\Requests\API\GetYourAPIRequest;

use App\Models\ResponseByUserDisc;
use App\Models\CanvaMiniDisq;
use App\Models\PasserTest;
use App\Models\Couleur;
use App\Models\Caracteristique;
use App\Models\Question;

use App\Repositories\ResponseByUserDiscRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ResponseByUserDiscResource;
use Response;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Storage;

use DB;

/**
 * Class ResponseByUserDiscController
 * @package App\Http\Controllers\API
 */

class ResponseByUserDiscAPIController extends AppBaseController
{
    /** @var  ResponseByUserDiscRepository */
    private $responseByUserDiscRepository;

    public function __construct(ResponseByUserDiscRepository $responseByUserDiscRepo)
    {
        $this->responseByUserDiscRepository = $responseByUserDiscRepo;
    }

    /**
     * Display a listing of the ResponseByUserDisc.
     * GET|HEAD /responseByUserDiscs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $responseByUserDiscs = $this->responseByUserDiscRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ResponseByUserDiscResource::collection($responseByUserDiscs), 'Response By User Discs retrieved successfully');
    }

    /**
     * Store a newly created ResponseByUserDisc in storage.
     * POST /responseByUserDiscs
     *
     * @param CreateResponseByUserDiscAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResponseByUserDiscAPIRequest $request)
    {
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
        if(empty($passer_test) || $passer_test->type != 'mini_disq')
            return $this->sendError('Something went wrong : "id_passer_test" !');
        
        $rows = [1,2,3,4,5,6,7,8,9,10];
        
        $valuable = [6,3,1,0]; 
        $points = explode(',' , $input['points']);
        $points = array_unique($points);

        if(count($points) != 4 || !in_array($input['row_id'], $rows))
            return $this->sendError('Please respect the correct format !');

        foreach (range(0, 3) as $number) {
            //Only 4 possibilities
            $point = $points[$number];
            if(!in_array($point, $valuable))
                return $this->sendError('Only 4 values are authorized !');


            $column = $number + 1;
            $data = array(
                'row' => $input['row_id'],
                'column' => $column,
                'point' => $point,
                'user_id' => $input['user_id'],
                'passer_test_id' => $input['passer_test_id'],
            );

            $redundance = false;
            $redundance = ResponseByUserDisc::where('user_id', $input['user_id'])
            ->where('passer_test_id', $input['passer_test_id'])
            ->where('row', $input['row_id'])
            ->where('column', $column)
            ->first();

            if($redundance)
                DB::table('response_by_user_discs')
                ->where('id', $redundance->id)
                ->update($data);
            else 
                $responseByUserDisc = ResponseByUserDisc::create($data);
        }

        //Stages
        $out_of_question = Question::where('questions.type', 'mini_disq')->orderBy('id', 'asc')->get();
        $out_of = count($out_of_question);

        $step = ResponseByUserDisc::select('row')
                    ->where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passer_test->id)
                    ->groupBy('row')
                    ->orderBy('row', 'desc')
                    ->get();

        foreach($out_of_question as $value){
            $check = ResponseByUserDisc::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $passer_test->id)
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

        $infos['step'] = $steps;
        $infos['out_of'] = $out_of; 

        if(isset($next_question))
            $infos['next_question'] = $next_question;

        return $this->sendResponse($infos, 'Response By User Disc saved successfully !');
    }

    /**
     * Display the specified ResponseByUserDisc.
     * GET|HEAD /responseByUserDiscs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ResponseByUserDisc $responseByUserDisc */
        $responseByUserDisc = $this->responseByUserDiscRepository->find($id);

        if (empty($responseByUserDisc)) {
            return $this->sendError('Response By User Disc not found');
        }

        return $this->sendResponse(new ResponseByUserDiscResource($responseByUserDisc), 'Response By User Disc retrieved successfully');
    }

    /**
     * Update the specified ResponseByUserDisc in storage.
     * PUT/PATCH /responseByUserDiscs/{id}
     *
     * @param int $id
     * @param UpdateResponseByUserDiscAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResponseByUserDiscAPIRequest $request)
    {
        $input = $request->all();

        /** @var ResponseByUserDisc $responseByUserDisc */
        $responseByUserDisc = $this->responseByUserDiscRepository->find($id);

        if (empty($responseByUserDisc)) {
            return $this->sendError('Response By User Disc not found');
        }

        $responseByUserDisc = $this->responseByUserDiscRepository->update($input, $id);

        return $this->sendResponse(new ResponseByUserDiscResource($responseByUserDisc), 'ResponseByUserDisc updated successfully');
    }

    /**
     * Remove the specified ResponseByUserDisc from storage.
     * DELETE /responseByUserDiscs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ResponseByUserDisc $responseByUserDisc */
        $responseByUserDisc = $this->responseByUserDiscRepository->find($id);

        if (empty($responseByUserDisc)) {
            return $this->sendError('Response By User Disc not found');
        }

        $responseByUserDisc->delete();

        return $this->sendSuccess('Response By User Disc deleted successfully');
    }

    public function get_your_animal(GetYourAPIRequest $request){
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
         if(empty($passer_test) || $passer_test->type != 'mini_disq')
             return $this->sendError('Something went wrong : "id_passer_test" !');

        //foreach column goes through them
        $score = collect(['Rouge' => 0, 'Jaune' => 0, 'Vert' => 0, 'Bleue' => 0]);
        $red = 0; //:1
        $yellow = 0; //:2
        $green = 0; //:3
        $blue = 0; //:4

        foreach (range(1, 4) as $number) {
            $red_column = 0; //:1
            $yellow_column = 0; //:2
            $green_column = 0; //:3
            $blue_column = 0; //:4
            $canva_mini_discs = CanvaMiniDisq::where('column', $number)->get();
            $row = 0; 
            foreach($canva_mini_discs as $case){
                $row++;
                $response_user = ResponseByUserDisc::where('user_id', $input['user_id'])
                ->where('passer_test_id', $input['passer_test_id'])
                ->where('row', $row)
                ->where('column', $number)
                ->first();

                if($response_user){
                    if($case->couleur_id == 1)
                        $red_column += $response_user->point;
                    if($case->couleur_id == 2)
                        $yellow_column += $response_user->point;
                    if($case->couleur_id == 3)
                        $green_column += $response_user->point;
                    if($case->couleur_id == 4)
                        $blue_column += $response_user->point;
                }
            }

            $red += $red_column;
            $yellow += $yellow_column;
            $green += $green_column;
            $blue += $blue_column;
        }

        $score['Rouge'] = $red;
        $score['Jaune'] = $yellow;
        $score['Vert'] = $green;
        $score['Bleue'] = $blue;

        $score = $score->sortDesc();
        $first = $score->take(1);

        $eky = $first->keys();

        $couleur = Couleur::where('libelle', $eky)->first();

        $infos['score'] = $score;
        $infos['caracteristiques'] = DB::table('caracteristiques')
                                    ->select('libelle')
                                    ->where('couleur_id', $couleur->id)
                                    ->get();
        $couleur_image = DB::table('images')
        ->select('libelle')
        ->where('id', $couleur->image_id)
        ->first();

        $mascotte_image = DB::table('images')
        ->select('libelle')
        ->where('id', $couleur->image_second_id)
        ->first();

        $infos['couleur_image'] = Storage::disk('s3')->url('images/'. $couleur_image->libelle); 
        $infos['mascotte_image'] = Storage::disk('s3')->url('images/'. $mascotte_image->libelle); 

        $message = "Votre couleur dominante est : " . $couleur->libelle . "\n Votre mascotte est le " . $couleur->mascotte;   
        
        //Set the new status of this current test
        DB::table('passer_tests')
        ->where('id', $input['passer_test_id'])
        ->update(['state' => 1]);

        return $this->sendResponse($infos, $message);

    }
}
