<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuestionAPIRequest;
use App\Http\Requests\API\UpdateQuestionAPIRequest;
use App\Models\Question;
use App\Models\Reponse;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\QuestionResource;
use Response;

use DB;

use Storage;
/**
 * Class QuestionController
 * @package App\Http\Controllers\API
 */

class QuestionAPIController extends AppBaseController
{
    /** @var  QuestionRepository */
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepo)
    {
        $this->questionRepository = $questionRepo;
    }

    /**
     * Display a listing of the Question.
     * GET|HEAD /questions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Question::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $questions = $query->get();

        foreach($questions as $question){
            $responses = Reponse::where('responses.question_id', $question->id )
                    ->select('responses.*')
                    ->get();
            $question->responses = $responses;
        }

        if(!isset($questions[0]))
            return $this->sendError("No questions found !");

        return $this->sendResponse($questions, 'Pubs retrieved successfully');
    }

    public function index_mini_disq(Request $request)
    {
        $questions = Question::where('questions.type', 'mini_disq')
                    ->select('questions.id', 'questions.libelle',)
                    ->where('questions.mini_disq_id', 1)
                    ->get();

        foreach($questions as $question){
            $responses = Reponse::where('responses.question_id', $question->id )
                        ->select('responses.valeur')
                        ->get();

            $question->responses = $responses;
        }

        if(!isset($questions[0]))
            return $this->sendError("No questions found !");

        return $this->sendResponse($questions, 'Questions retrieved successfully');
    }

    public function index_roue_de_vie(Request $request)
    {
        $questions = array();
        $raw_questions = Question::where('questions.type', 'roue_de_vie')
                    ->select('domaines.libelle as domaine', 'domaines.image_id as image', 'questions.id as question_id', 'questions.libelle as libelle',)
                    ->where('questions.roue_de_vie_id', 1)
                    ->join('domaines', 'questions.domaine_id', 'domaines.id' )
                    ->get();

        foreach($raw_questions as $question){
            $image = DB::table('images')
                ->select('libelle')
                ->where('id', $question->image)
                ->first();
            $question->image = Storage::disk('s3')->url('images/'. $image->libelle); 
            array_push($questions, $question);
        }

        if(!isset($questions[0]))
            return $this->sendError("No questions found !");

        return $this->sendResponse($questions, 'Questions retrieved successfully');
    }

    public function index_competence(Request $request)
    {
        $questions = array();
        $raw_questions = Question::where('questions.type', 'competence')
                    ->select('questions.id', 'questions.libelle', 'questions.image_id as image')
                    ->where('questions.competence_id', 1)
                    ->get();

        foreach($raw_questions as $question){
            $image = DB::table('images')
                ->select('libelle')
                ->where('id', $question->image)
                ->first();
            $question->image = Storage::disk('s3')->url('images/'. $image->libelle); 
            array_push($questions, $question);
        }

        if(!isset($questions[0]))
            return $this->sendError("No questions found !");

        return $this->sendResponse($questions, 'Questions retrieved successfully');
    }

    /**
     * Store a newly created Question in storage.
     * POST /questions
     *
     * @param CreateQuestionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionAPIRequest $request)
    {
        $input = $request->all();

        $question = $this->questionRepository->create($input);

        return $this->sendResponse(new QuestionResource($question), 'Question saved successfully');
    }

    /**
     * Display the specified Question.
     * GET|HEAD /questions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        return $this->sendResponse(new QuestionResource($question), 'Question retrieved successfully');
    }

    /**
     * Update the specified Question in storage.
     * PUT/PATCH /questions/{id}
     *
     * @param int $id
     * @param UpdateQuestionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        $question = $this->questionRepository->update($input, $id);

        return $this->sendResponse(new QuestionResource($question), 'Question updated successfully');
    }

    /**
     * Remove the specified Question from storage.
     * DELETE /questions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        $question->delete();

        return $this->sendSuccess('Question deleted successfully');
    }
}
