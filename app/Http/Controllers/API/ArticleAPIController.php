<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateArticleAPIRequest;
use App\Http\Requests\API\UpdateArticleAPIRequest;

use App\Models\Article;
use App\Models\Commentaire;
use App\Models\PasserTest;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use Storage;
use DB;
/**
 * Class ArticleController
 * @package App\Http\Controllers\API
 */

class ArticleAPIController extends AppBaseController
{
    /**
     * Display a listing of the Article.
     * GET|HEAD /articles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $articles = $query->get();

        return $this->sendResponse($articles->toArray(), 'Articles retrieved successfully');
    }

    /**
     * Store a newly created Article in storage.
     * POST /articles
     *
     * @param CreateArticleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateArticleAPIRequest $request)
    {
        $input = $request->all();

        /** @var Article $article */
        $article = Article::create($input);

        return $this->sendResponse($article->toArray(), 'Article saved successfully');
    }

    /**
     * Display the specified Article.
     * GET|HEAD /articles/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request, $id)
    {
        /** @var Article $article */
        $article = Article::find($id);

        if(empty($article)) {
            return $this->sendError('Article not found');
        }

        $token = $request->header('Authorization');
        $user = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        $passer_test = PasserTest::where('quizz_id', $article->quizz_id)->where('user_id', $user->user_id)->whereNotNull('point_id')->first();

        //Get the quizzes 
        $quizzs = array();
        
        $raw_quizzs = DB::table('quizzs')
                ->select('question_quizzs.id', 'quizzs.title', 'question_quizzs.libelle')
                ->join('question_quizzs', 'question_quizzs.quizz_id', 'quizzs.id')
                ->where('quizzs.id', $article->quizz_id)
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

        $article->pourcentage = 0;
        if(!empty($passer_test))
            $article->pourcentage = 100;

        $article->quizz_id = $article->quizz;
        $article->quizz = $quizzs;

        //Get comments
        $comments = Commentaire::select('text', 'user_id', 'created_at', 'updated_at')->where('article_id', $article->id)->get();
        if(!empty($comments))
            $article->comments = $comments;

        return $this->sendResponse($article, 'Article retrieved successfully');
    }

    /**
     * Update the specified Article in storage.
     * PUT/PATCH /articles/{id}
     *
     * @param int $id
     * @param UpdateArticleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticleAPIRequest $request)
    {
        /** @var Article $article */
        $article = Article::find($id);

        if (empty($article)) {
            return $this->sendError('Article not found');
        }

        $article->fill($request->all());
        $article->save();

        return $this->sendResponse($article->toArray(), 'Article updated successfully');
    }

    /**
     * Remove the specified Article from storage.
     * DELETE /articles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Article $article */
        $article = Article::find($id);

        if (empty($article)) {
            return $this->sendError('Article not found');
        }

        $article->delete();

        return $this->sendSuccess('Article deleted successfully');
    }
}
