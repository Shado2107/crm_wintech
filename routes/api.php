<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/logout', [App\Http\Controllers\API\LoginController::class, 'logout'])->middleware('EnsureTokenIsValid')->name('api.logout'); 
Route::post('/signup/me', [App\Http\Controllers\API\LoginController::class, 'register'])->name('api.signup'); 
Route::post('/signin/me', [App\Http\Controllers\API\LoginController::class, 'login'])->name('api.signin'); 
Route::post('/oauth/token', [App\Http\Controllers\API\LoginController::class, 'refresh_token'])->name('api.refresh'); 

Route::post('/email/log', [App\Http\Controllers\API\LoginController::class, 'email_log'])->name('email.log'); 

Route::get('/see-my-guests', [App\Http\Controllers\API\LoginController::class, 'see_my_guests'])->middleware('EnsureTokenIsValid'); 


Route::get('/question/roueVie', [App\Http\Controllers\API\QuestionAPIController::class, 'index_roue_de_vie'])->middleware('EnsureTokenIsValid')->name('roueVie.question'); 
Route::post('/domain/roueVie', [App\Http\Controllers\API\ResponseByUserAPIController::class, 'domaine_roue_vie'])->middleware('EnsureTokenIsValid')->name('roueVie.domain');
Route::post('/domain/priorities', [App\Http\Controllers\API\ResponseByUserAPIController::class, 'domaine_priorities'])->middleware('EnsureTokenIsValid')->name('roueVie.priority');

Route::get('/question/disque', [App\Http\Controllers\API\QuestionAPIController::class, 'index_mini_disq'])->middleware('EnsureTokenIsValid')->name('minidisq.question'); 
Route::post('/getYourAnimal', [App\Http\Controllers\API\ResponseByUserDiscAPIController::class, 'get_your_animal'])->middleware('EnsureTokenIsValid')->name('minidisq.animal');

Route::get('/question/competence', [App\Http\Controllers\API\QuestionAPIController::class, 'index_competence'])->middleware('EnsureTokenIsValid')->name('competence.question'); 
Route::post('/competence/all', [App\Http\Controllers\API\ResponseByUserAPIController::class, 'competences'])->middleware('EnsureTokenIsValid')->name('competence.see');

Route::post('/quizz/stats', [App\Http\Controllers\API\ResponseUserQuizzAPIController::class, 'stats'])->middleware('EnsureTokenIsValid')->name('quizzs.stats');

Route::get('/profile/points', [App\Http\Controllers\API\PointsAPIController::class, 'profile_points'])->middleware('EnsureTokenIsValid')->name('profile.points'); 

/*
| Resources
*/
Route::resource('passer_tests', App\Http\Controllers\API\PasserTestAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('questions', App\Http\Controllers\API\QuestionAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('response_by_user_disque', App\Http\Controllers\API\ResponseByUserDiscAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('response_by_user', App\Http\Controllers\API\ResponseByUserAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('apprenant_domains', App\Http\Controllers\API\ApprenantDomainAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('videos', App\Http\Controllers\API\VideoAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('audios', App\Http\Controllers\API\AudioAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('articles', App\Http\Controllers\API\ArticleAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('parcours_formations', App\Http\Controllers\API\ParcoursFormationAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('response_quizzs', App\Http\Controllers\API\ResponsesQuizzAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('question_quizzs', App\Http\Controllers\API\QuestionQuizzAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('response_user_quizzs', App\Http\Controllers\API\ResponseUserQuizzAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('challenges', App\Http\Controllers\API\ChallengeAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('question_challenges', App\Http\Controllers\API\QuestionChallengeAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('response_user_challenges', App\Http\Controllers\API\ResponseUserChallengeAPIController::class)->middleware('EnsureTokenIsValid');
Route::resource('commentaires', App\Http\Controllers\API\CommentaireAPIController::class)->middleware('EnsureTokenIsValid');

//Route::resource('canva_mini_disqs', App\Http\Controllers\API\CanvaMiniDisqAPIController::class);
//Route::resource('caracteristiques', App\Http\Controllers\API\CaracteristiqueAPIController::class);
//Route::resource('quizzs', App\Http\Controllers\API\QuizzAPIController::class);
//Route::resource('challenges', App\Http\Controllers\API\ChallengeAPIController::class);
//Route::resource('points', App\Http\Controllers\API\PointsAPIController::class);
//Route::resource('domaines', App\Http\Controllers\API\DomaineAPIController::class);
//Route::resource('apprenants', App\Http\Controllers\API\ApprenantAPIController::class);
//Route::resource('mini_disqs', App\Http\Controllers\API\MiniDisqAPIController::class);
//Route::resource('responses', App\Http\Controllers\API\ResponseAPIController::class);
//Route::resource('roue_vies', App\Http\Controllers\API\RoueVieAPIController::class);







Route::resource('citations', App\Http\Controllers\API\CitationAPIController::class);
