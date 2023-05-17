<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponseUserChallengeAPIRequest;
use App\Http\Requests\API\UpdateResponseUserChallengeAPIRequest;

use App\Models\ResponseUserChallenge;
use App\Models\QuestionChallenge;
use App\Models\PasserTest;
use App\Models\Points;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use DB;
use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;


/**
 * Class ResponseUserChallengeController
 * @package App\Http\Controllers\API
 */

class ResponseUserChallengeAPIController extends AppBaseController
{
    /**
     * Display a listing of the ResponseUserChallenge.
     * GET|HEAD /responseUserChallenges
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ResponseUserChallenge::query();

        if ($request->get('skip')) 
            $query->skip($request->get('skip'));
        
        if ($request->get('limit')) 
            $query->limit($request->get('limit'));

        $responseUserChallenges = $query->get();

        return $this->sendResponse($responseUserChallenges->toArray(), 'Response User Challenges retrieved successfully');
    }

    /**
     * Store a newly created ResponseUserChallenge in storage.
     * POST /responseUserChallenges
     *
     * @param CreateResponseUserChallengeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResponseUserChallengeAPIRequest $request)
    {
        $token = $request->header('Authorization');
        $input = $request->all();
        $infos = array();
        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $input['user_id'] = $user->user_id;

        //Question challenge exists 
        $question = QuestionChallenge::find($input['question_challenge_id']);
        if(empty($question))
            return $this->sendError('Question not found !');
        
        //Workflow Test : Passer Test exists
        $passer_test = PasserTest::find($input['passer_test_id']);
        if(empty($passer_test) || $passer_test->type != 'challenge')
            return $this->sendError('Something went wrong : "id_passer_test" !');

        //No redundance on question for each row
        $redundance = ResponseUserChallenge::where('user_id', $input['user_id'])
                    ->where('passer_test_id', $input['passer_test_id'])
                    ->where('question_challenge_id', $input['question_challenge_id'])
                    ->first();

        if($redundance)
            DB::table('response_user_challenges')
            ->where('id', $redundance->id)
            ->update($input);
        else
            $responseUserChallenge = ResponseUserChallenge::create($input);
        
        $redundance_points = PasserTest::where('user_id', $input['user_id'])
                            ->where('type', 'challenge')
                            ->where('challenge_id', $question->challenge_id)
                            ->whereNotNull('point_id')
                            ->first();

        if(empty($redundance_points)){
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

        $infos['score'] = $score;

        //Get Pre-signed Urls for uploading objects
        /** @var \Illuminate\Filesystem\FilesystemAdapter $fs */
        $fs = Storage::disk('s3');
        /** @var \League\Flysystem\Filesystem $driver */
        $driver = $fs->getDriver();
        /** @var \League\Flysystem\AwsS3v3\AwsS3Adapter $adapter */
        $adapter = $driver->getAdapter();
        /** @var \Aws\S3\S3Client $client */
        $client = $adapter->getClient();
        
        $command = $client->getCommand('PutObject', [
            'Bucket' => 'moveskills',
            'Key'    => 'activities/challenges/' .$input['valeur'],
        ]);  
        
        $request = $client->createPresignedRequest($command, '+2 hours');

        $signedUrl = (string) $request->getUri();
        
        $infos['signed_url'] = $signedUrl;

        return $this->sendResponse($infos, 'Response User Challenge saved successfully');
    }

    /**
     * Display the specified ResponseUserChallenge.
     * GET|HEAD /responseUserChallenges/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ResponseUserChallenge $responseUserChallenge */
        $responseUserChallenge = ResponseUserChallenge::find($id);

        if (empty($responseUserChallenge)) {
            return $this->sendError('Response User Challenge not found');
        }

        return $this->sendResponse($responseUserChallenge->toArray(), 'Response User Challenge retrieved successfully');
    }

    /**
     * Update the specified ResponseUserChallenge in storage.
     * PUT/PATCH /responseUserChallenges/{id}
     *
     * @param int $id
     * @param UpdateResponseUserChallengeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResponseUserChallengeAPIRequest $request)
    {
        /** @var ResponseUserChallenge $responseUserChallenge */
        $responseUserChallenge = ResponseUserChallenge::find($id);

        if (empty($responseUserChallenge)) {
            return $this->sendError('Response User Challenge not found');
        }

        $responseUserChallenge->fill($request->all());
        $responseUserChallenge->save();

        return $this->sendResponse($responseUserChallenge->toArray(), 'ResponseUserChallenge updated successfully');
    }

    /**
     * Remove the specified ResponseUserChallenge from storage.
     * DELETE /responseUserChallenges/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ResponseUserChallenge $responseUserChallenge */
        $responseUserChallenge = ResponseUserChallenge::find($id);

        if (empty($responseUserChallenge)) {
            return $this->sendError('Response User Challenge not found');
        }

        $responseUserChallenge->delete();

        return $this->sendSuccess('Response User Challenge deleted successfully');
    }
}
