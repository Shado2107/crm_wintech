<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now editer something great!
|
*/

Route::get('/lister_projets', 'App\Http\Controllers\ProjetController@lister_projets');

Route::get('/editer_projet_1/{id}', 'App\Http\Controllers\ProjetController@editer_projet_1')->name('editer_projet_1');
Route::post('/update_proje_1/{id}', 'App\Http\Controllers\ProjetController@update_projet_1')->name('update_projet_1');

Route::get('/editer_projet_2/{id}', 'App\Http\Controllers\ProjetController@editer_projet_2')->name('editer_projet_2');
Route::post('/update_proje_2/{id}', 'App\Http\Controllers\ProjetController@update_projet_2')->name('update_projet_2');

Route::get('/editer_projet_3/{id}', 'App\Http\Controllers\ProjetController@editer_projet_3')->name('editer_projet_3');
Route::post('/update_proje_3/{id}', 'App\Http\Controllers\ProjetController@update_projet_3')->name('update_projet_3');

Route::get('/editer_projet_4/{id}', 'App\Http\Controllers\ProjetController@editer_projet_4')->name('editer_projet_4');
Route::post('/update_proje_4/{id}', 'App\Http\Controllers\ProjetController@update_projet_4')->name('update_projet_4');

Route::get('/editer_projet_5/{id}', 'App\Http\Controllers\ProjetController@editer_projet_5')->name('editer_projet_5');
Route::post('/update_proje_5/{id}', 'App\Http\Controllers\ProjetController@update_projet_5')->name('update_projet_5');

Route::get('/editer_projet_6/{id}', 'App\Http\Controllers\ProjetController@editer_projet_6')->name('editer_projet_6');
Route::post('/update_proje_6/{id}', 'App\Http\Controllers\ProjetController@update_projet_6')->name('update_projet_6');


Route::get('/editer_secteur_projet/{id}', 'App\Http\Controllers\ProjetController@editer_secteur_projet')->name('editer_secteur_projet');
Route::post('/update_secteur_projet/{id}', 'App\Http\Controllers\ProjetController@update_secteur_projet')->name('update_secteur_projet');

Route::get('/editer_secteur_imple/{id}', 'App\Http\Controllers\ProjetController@editer_secteur_imple')->name('editer_secteur_imple');
Route::post('/update_secteur_imple/{id}', 'App\Http\Controllers\ProjetController@update_secteur_imple')->name('update_secteur_imple');

Route::get('/editer_secteur_investi/{id}', 'App\Http\Controllers\ProjetController@editer_secteur_investi')->name('editer_secteur_investi');
Route::post('/update_secteur_investi/{id}', 'App\Http\Controllers\ProjetController@update_secteur_investi')->name('update_secteur_investi');

Route::get('/editer_secteur_realiser/{id}', 'App\Http\Controllers\ProjetController@editer_secteur_realiser')->name('editer_secteur_realiser');
Route::post('/update_secteur_realiser/{id}', 'App\Http\Controllers\ProjetController@update_secteur_realiser')->name('update_secteur_realiser');




Route::get('/create_projet_1', 'App\Http\Controllers\ProjetController@create_projet_1');
Route::post('/store_proje_1', 'App\Http\Controllers\ProjetController@store_projet_1')->name('store_projet_1');

Route::get('/create_projet_2/{id}', 'App\Http\Controllers\ProjetController@create_projet_2')->name('create_projet_2');
Route::post('/store_proje_2/{id}', 'App\Http\Controllers\ProjetController@store_projet_2')->name('store_projet_2');

Route::get('/create_projet_3/{id}', 'App\Http\Controllers\ProjetController@create_projet_3')->name('create_projet_3');
Route::post('/store_proje_3/{id}', 'App\Http\Controllers\ProjetController@store_projet_3')->name('store_projet_3');

Route::get('/create_projet_4/{id}', 'App\Http\Controllers\ProjetController@create_projet_4')->name('create_projet_4');
Route::post('/store_proje_4/{id}', 'App\Http\Controllers\ProjetController@store_projet_4')->name('store_projet_4');

Route::get('/create_projet_5/{id}', 'App\Http\Controllers\ProjetController@create_projet_5')->name('create_projet_5');
Route::post('/store_proje_5/{id}', 'App\Http\Controllers\ProjetController@store_projet_5')->name('store_projet_5');

Route::get('/create_projet_6/{id}', 'App\Http\Controllers\ProjetController@create_projet_6')->name('create_projet_6');
Route::post('/store_proje_6/{id}', 'App\Http\Controllers\ProjetController@store_projet_6')->name('store_projet_6');

Route::delete('/delete_projet/{id}', 'App\Http\Controllers\ProjetController@delete_projet')->name('delete_projet');
Route::get('/details_projet/{id}', 'App\Http\Controllers\ProjetController@details_projet')->name('details_projet');

Auth::routes();  
Route::post('/get_token', 'App\Http\Controllers\AdminController@transaction')->name('get_token');
Route::get('/get_transaction', 'App\Http\Controllers\AdminController@get_transaction');
Route::post('/transfert_contact', 'App\Http\Controllers\AdminController@transfert_contact')->name('transfert_contact');

Route::get('/connexion', 'App\Http\Controllers\AdminController@connexion');
Route::post('/connexion', 'App\Http\Controllers\AdminController@login')->name('connecter');
Route::get('/inscription', 'App\Http\Controllers\AdminController@inscription');
Route::post('/inscription_store', 'App\Http\Controllers\AdminController@inscription_store')->name('inscription_store');

Route::get('/authorized/google', 'App\Http\Controllers\AdminController@redirectToGoogle');
Route::get('/authorized/google/callback', 'App\Http\Controllers\AdminController@handleCallback');

Route::get('login/{provider}', 'App\Http\Controllers\AdminController@redirectToProvider');
Route::get('{provider}/callback', 'App\Http\Controllers\AdminController@handleProviderCallback');
// Route::get('/auth/linkedin', 'App\Http\Controllers\AdminController@linkedinRedirect');
// Route::get('/auth/linkedin/callback', 'App\Http\Controllers\AdminController@linkedinCallback');

Route::group(['middleware' => 'Connecter'], function(){
    
   Route::get('/demande_transaction', 'App\Http\Controllers\AdminController@demande_transaction');
   Route::post('/demande_transactionStore', 'App\Http\Controllers\AdminController@demande_transactionStore')->name('demande_transactionStore');
   Route::patch('/demande_transactionUpdate/{id}', 'App\Http\Controllers\AdminController@demande_transactionUpdate')->name('demande_transactionUpdate');

    
    Route::get('/lister_quizzs', 'App\Http\Controllers\ParcourFormationController@lister_quizzs');
    Route::get('/lister_citations', 'App\Http\Controllers\ParcourFormationController@lister_citations');
    
    Route::get('/editer_quizz_question/{id}', 'App\Http\Controllers\ParcourFormationController@editer_quizz_question')->name('editer_quizz_question');
    Route::get('/editer_quizz_response/{id}', 'App\Http\Controllers\ParcourFormationController@editer_quizz_response')->name('editer_quizz_response');
    Route::get('/editer_citation/{id}', 'App\Http\Controllers\ParcourFormationController@editer_citation')->name('editer_citation');

    Route::patch('/update_quizz_question/{id}', 'App\Http\Controllers\ParcourFormationController@update_quizz_question')->name('update_quizz_question');
    Route::patch('/update_quizz_response/{id}', 'App\Http\Controllers\ParcourFormationController@update_quizz_response')->name('update_quizz_response');
    Route::patch('/update_citation/{id}', 'App\Http\Controllers\ParcourFormationController@update_citation')->name('update_citation');

    Route::delete('/supprime_quizz_question/{id}', 'App\Http\Controllers\ParcourFormationController@destroy_quizz_question')->name('delete_quizz_question');
    Route::delete('/supprime_quizz_response/{id}', 'App\Http\Controllers\ParcourFormationController@destroy_quizz_response')->name('delete_quizz_response');
    Route::delete('/supprime_citation/{id}', 'App\Http\Controllers\ParcourFormationController@destro_citation')->name('delete_citation');

    
    Route::get('/parcour_vendus', 'App\Http\Controllers\ParcourDashboardController@parcour_vendus');
    Route::get('/transactions', 'App\Http\Controllers\ParcourDashboardController@transactions');
    Route::get('/video_total', 'App\Http\Controllers\ParcourDashboardController@video_total');
    Route::get('/filtre_video_total', 'App\Http\Controllers\ParcourDashboardController@filtre_video_total')->name('filtre_video_total');
    
    // admin
    Route::get('/tous_parcour_vendus', 'App\Http\Controllers\ParcourDashboardController@tous_parcour_vendus');
    Route::get('/toutes_lestransactions', 'App\Http\Controllers\ParcourDashboardController@toutes_lestransactions');
    Route::get('/toutes_lesvideo', 'App\Http\Controllers\ParcourDashboardController@toutes_lesvideo');
    Route::get('/tous_lesapprenants', 'App\Http\Controllers\ParcourDashboardController@tous_lesapprenants');
    Route::get('/tous_lesparcours', 'App\Http\Controllers\ParcourDashboardController@tous_lesparcours');
    
    Route::get('/ajout_formateur_admin', 'App\Http\Controllers\ParcourDashboardController@create_formateur');
    Route::post('/ajout_formateur_admins', 'App\Http\Controllers\ParcourDashboardController@store_formateur');
    // end admin
    
    Route::get('/inviter_formateur', 'App\Http\Controllers\ParcourDashboardController@inviter_formateur_create');
    Route::post('/inviter_formateurs', 'App\Http\Controllers\ParcourDashboardController@inviter_formateur_store');
    Route::get('/mes_inviter', 'App\Http\Controllers\ParcourDashboardController@mes_inviter');
    
    Route::get('/inviter_affilation', 'App\Http\Controllers\ParcourDashboardController@inviter_affilation_create');
    Route::post('/inviter_affilations', 'App\Http\Controllers\ParcourDashboardController@inviter_affilation_store');
    Route::get('/mes_affilation', 'App\Http\Controllers\ParcourDashboardController@mes_affilations');

    Route::get('/dashboard_admin', 'App\Http\Controllers\AdminController@dashboard_admin');
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@dashboard');
    Route::get('/filepondget', 'App\Http\Controllers\ParcourFormationController@filepondget');
    Route::post('/filepond', 'App\Http\Controllers\ParcourFormationController@filepond')->name('filepond');
    Route::post('/filepondAudio', 'App\Http\Controllers\ParcourFormationController@filepondAudio')->name('filepondAudio');
    Route::get('/mes-apprenants', 'App\Http\Controllers\ParcourFormationController@mes_apprenants');
    Route::get('/profil-apprenants/{id}', 'App\Http\Controllers\ParcourFormationController@profil_apprenants')->name('profil_apprenants');

    Route::get('/editer-parcours-podcastStep1/{id}', 'App\Http\Controllers\ParcourFormationController@editer_podcast')->name('editer_podcast');
    Route::patch('/editer-parcours-podcastStoreStep1/{id}', 'App\Http\Controllers\ParcourFormationController@editer_parcours_podcastStoreStep1')->name('editer_parcours_podcastStoreStep1');
    Route::patch('/editer_parcours_podcast/{id}', 'App\Http\Controllers\ParcourFormationController@editer_parcours_podcast')->name('editer_parcours_podcast');
    Route::patch('/editer_parcours_challenge/{id}', 'App\Http\Controllers\ParcourFormationController@editer_parcours_challenge')->name('editer_parcours_challenge');

    Route::get('/editer-parcours-formationStep1/{id}', 'App\Http\Controllers\ParcourFormationController@editer_formation')->name('editer_formation');
    Route::patch('/editer-parcours-formationStoreStep1/{id}', 'App\Http\Controllers\ParcourFormationController@editer_parcours_formationStoreStep1')->name('editer_parcours_formationStoreStep1');
    Route::patch('/editer-parcours-formationStoreStep1audio/{id}', 'App\Http\Controllers\ParcourFormationController@editer_parcours_audio')->name('editer_parcours_audio');

    Route::get('/editer-parcours-challengeStep1/{id}', 'App\Http\Controllers\ParcourFormationController@editer_challenge')->name('editer_challenge');
    Route::patch('/editer-parcours-challengeStoreStep1/{id}', 'App\Http\Controllers\ParcourFormationController@editer_parcours_challengeStoreStep1')->name('editer_parcours_challengeStoreStep1');

    Route::get('/transaction', 'App\Http\Controllers\ParcourFormationController@transaction');
    Route::get('/parametre/{id}', 'App\Http\Controllers\ParcourFormationController@parametre')->name('parametre');
    Route::patch('/update_parametre/{id}', 'App\Http\Controllers\ParcourFormationController@update_parametre')->name('update_parametre');
    Route::get('/parametre_mdp/{id}', 'App\Http\Controllers\ParcourFormationController@parametre_mdp')->name('parametre_mdp');
    Route::patch('/update_parametre_mdp/{id}', 'App\Http\Controllers\ParcourFormationController@update_parametre_mdp')->name('update_parametre_mdp');

    Route::get('/mes-parcours', 'App\Http\Controllers\ParcourFormationController@mes_parcours');
    Route::get('/dashboard_cinetpay', 'App\Http\Controllers\ParcourFormationController@parcour_apprenant');
    // Route::get('/creation-parcours-formation', 'App\Http\Controllers\ParcourFormationController@create_parcours');
    Route::get('/creation-parcours-formation-activite', 'App\Http\Controllers\ParcourFormationController@create_parcours_activite');
    Route::post('/creation-parcours-formationStore', 'App\Http\Controllers\ParcourFormationController@store_parcours')->name('store_parcours_formation');

    Route::get('/mes-activites', 'App\Http\Controllers\ActiviteController@mes_activites');
    Route::get('/creation-activites', 'App\Http\Controllers\ActiviteController@create_activites');
    Route::post('/creation-activitesStore', 'App\Http\Controllers\ActiviteController@store_activites')->name('store_activites');
    
    Route::get('/ajout_citation/{id}', 'App\Http\Controllers\ParcourFormationController@ajout_citation')->name('ajout_citation');
    Route::post('/ajout_citationStore', 'App\Http\Controllers\ParcourFormationController@ajout_citationStore')->name('ajout_citationStore');


    Route::delete('/suprime-activites/{id}', 'App\Http\Controllers\ActiviteController@destroy_activites')->name('delete_activites');
    Route::delete('/suprime-parcours/{id}', 'App\Http\Controllers\ParcourFormationController@destroy_parcour')->name('delete_parcour');
    Route::delete('/suprime-video/{id}', 'App\Http\Controllers\ParcourFormationController@destroy_video')->name('delete_video');
    Route::delete('/suprime-audio/{id}', 'App\Http\Controllers\ParcourFormationController@destroy_audio')->name('delete_audio');
    Route::delete('/suprime-podcast/{id}', 'App\Http\Controllers\ParcourFormationController@destroy_podcast')->name('delete_podcast');
    Route::delete('/suprime-challenge/{id}', 'App\Http\Controllers\ParcourFormationController@destroy_challenge')->name('delete_challenge');

    Route::get('/creation-parcours-formationStep1', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStep1');
    Route::post('/creation-parcours-formationStoreStep1', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStoreStep1')->name('creation_parcours_formationStoreStep1');
    Route::get('/modifier-parcours-formationStep1/{id}', 'App\Http\Controllers\ParcourFormationController@modifier_parcours_formationStep1')->name('modifier_parcours_formationStep1');
    Route::patch('/modifier-parcours-formationStoreStep1/{id}', 'App\Http\Controllers\ParcourFormationController@modifier_parcours_formationStoreStep1')->name('modifier_parcours_formationStoreStep1');
    Route::get('/details-parcours-formationStep1/{id}', 'App\Http\Controllers\ParcourFormationController@details_parcours_formationStep1')->name('details_parcours_formationStep1');

    Route::get('/publier/parcours/{id}', 'App\Http\Controllers\ParcourFormationController@publier')->name('publier');
    Route::get('/ajouter_contenu/{id}', 'App\Http\Controllers\ParcourFormationController@ajouter_contenu')->name('ajouter_contenu');
    Route::get('/ajouter_formation/{id}', 'App\Http\Controllers\ParcourFormationController@ajouter_formation')->name('ajouter_formation');
    Route::get('/config_formation/{id}', 'App\Http\Controllers\ParcourFormationController@config_formation')->name('config_formation');
    Route::get('/ajouter_podcast/{id}', 'App\Http\Controllers\ParcourFormationController@ajouter_podcast')->name('ajouter_podcast');
    Route::get('/ajouter_challenge/{id}', 'App\Http\Controllers\ParcourFormationController@ajouter_challenge')->name('ajouter_challenge');

    Route::get('/details_formation/{id}', 'App\Http\Controllers\ParcourFormationController@details_formation')->name('details_formation');
    Route::get('/details_podcast/{id}', 'App\Http\Controllers\ParcourFormationController@details_podcast')->name('details_podcast');
    Route::get('/details_challenge/{id}', 'App\Http\Controllers\ParcourFormationController@details_challenge')->name('details_challenge');
    Route::get('/editer_formation_audio/{id}', 'App\Http\Controllers\ParcourFormationController@editer_formation_audio')->name('editer_formation_audio');
    Route::get('/ajouter_formation_quizz/{id}', 'App\Http\Controllers\ParcourFormationController@ajouter_formation_quizz')->name('ajouter_formation_quizz');
    Route::patch('/ajouter_quizz/{id}', 'App\Http\Controllers\ParcourFormationController@ajouter_quizz')->name('ajouter_quizz');

    Route::get('/modifier_formation/{id}', 'App\Http\Controllers\ParcourFormationController@modifier_formation')->name('modifier_formation');
    Route::get('/modifier_podcast/{id}', 'App\Http\Controllers\ParcourFormationController@modifier_podcast')->name('modifier_podcast');
    Route::get('/modifier_challenge/{id}', 'App\Http\Controllers\ParcourFormationController@modifier_challenge')->name('modifier_challenge');

    Route::get('/creation-parcours-formationStep2', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStep2');
    Route::post('/creation_parcours_formationStoreStep2', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStoreStep2')->name('creation_parcours_formationStoreStep2');
    
    Route::get('/creation-parcours-formationStep3', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStep3');
    Route::post('/creation-parcours-formationStoreStep3', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStoreStep3')->name('creation_parcours_formationStoreStep3');
   
    Route::get('/creation-parcours-formationStep4', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStep4');
    Route::post('/creation-parcours-formationStoreStep4', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStoreStep4')->name('creation_parcours_formationStoreStep4');

    Route::get('/creation-parcours-formationStep5', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStep5');
    Route::post('/creation-parcours-formationStoreStep5', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStoreStep5')->name('creation_parcours_formationStoreStep5');
    
    Route::get('/creation-parcours-formationStep6', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStep6');
    Route::post('/creation-parcours-formationStoreStep6', 'App\Http\Controllers\ParcourFormationController@creation_parcours_formationStoreStep6')->name('creation_parcours_formationStoreStep6');

    Route::get('/creation-programme-formationStep1', 'App\Http\Controllers\ParcourFormationController@creation_programme_formationStep1');
    Route::post('/creation-programme-formationStoreStep1', 'App\Http\Controllers\ParcourFormationController@creation_programme_formationStoreStep1')->name('creation_programme_formationStoreStep1');

    Route::get('/creation-programme-formationStep2', 'App\Http\Controllers\ParcourFormationController@creation_programme_formationStep2');
    Route::post('/creation-programme-formationStoreStep2', 'App\Http\Controllers\ParcourFormationController@creation_programme_formationStoreStep2')->name('creation_programme_formationStoreStep2');
    
    Route::get('/creation-programme-formationStep3', 'App\Http\Controllers\ParcourFormationController@creation_programme_formationStep3');
    Route::post('/creation-programme-formationStoreStep3', 'App\Http\Controllers\ParcourFormationController@creation_programme_formationStoreStep3')->name('creation_programme_formationStoreStep3');

    
    
    Route::get('/creation-parcours-formation', function () {
        return view('creation-parcours-formation');
    });
    Route::get('/mes-programmes', function () {
        return view('mes-programmes');
    }); 
    Route::get('/creation-programme', function () {
        return view('creation-programme');
    });
    Route::get('/mes-clients', function () {
        return view('mes-clients');
    });
    Route::get('/listes-apprenants', function () {
        return view('listes-apprenants');
    });
   
    
});

Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/login1', function () {
    return view('login1');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/forgetPasswoord', function () {
    return view('forgetPasswoord');
});
// separ
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('apprenants', App\Http\Controllers\ApprenantController::class);


Route::resource('canvaMiniDisqs', App\Http\Controllers\CanvaMiniDisqController::class);


Route::resource('points', App\Http\Controllers\PointsController::class);


Route::resource('passerTests', App\Http\Controllers\PasserTestController::class);


Route::resource('questions', App\Http\Controllers\QuestionController::class);


Route::resource('domaines', App\Http\Controllers\DomaineController::class);


Route::resource('miniDisqs', App\Http\Controllers\MiniDisqController::class);


Route::resource('responses', App\Http\Controllers\ResponseController::class);


Route::resource('responseByUserDiscs', App\Http\Controllers\ResponseByUserDiscController::class);


Route::resource('roueVies', App\Http\Controllers\RoueVieController::class);


Route::resource('responseByUsers', App\Http\Controllers\ResponseByUserController::class);


Route::resource('apprenantDomains', App\Http\Controllers\ApprenantDomainController::class);


Route::resource('caracteristiques', App\Http\Controllers\CaracteristiqueController::class);


Route::resource('videos', App\Http\Controllers\VideoController::class);


Route::resource('audio', App\Http\Controllers\AudioController::class);


Route::resource('articles', App\Http\Controllers\ArticleController::class);


Route::resource('parcoursFormations', App\Http\Controllers\ParcoursFormationController::class);


Route::resource('quizzs', App\Http\Controllers\QuizzController::class);


Route::resource('responsesQuizzs', App\Http\Controllers\ResponsesQuizzController::class);


Route::resource('questionsQuizzs', App\Http\Controllers\QuestionsQuizzController::class);


Route::resource('responseUserQuizzs', App\Http\Controllers\ResponseUserQuizzController::class);


Route::resource('challenges', App\Http\Controllers\challengeController::class);


Route::resource('questionChallenges', App\Http\Controllers\QuestionChallengeController::class);


Route::resource('responseUserChallenges', App\Http\Controllers\ResponseUserChallengeController::class);


Route::resource('commentaires', App\Http\Controllers\CommentaireController::class);


Route::resource('citations', App\Http\Controllers\CitationController::class);
// Route::get('/mes-parcours', function () {
//     return view('mes-parcours');
// });
// Route::get('/creation-parcours-formation', function () {
//     return view('creation-parcours-formation');
// });
// Route::get('/mes-programmes', function () {
//     return view('mes-programmes');
// });
// Route::get('/creation-programme', function () {
//     return view('creation-programme');
// });
// Route::get('/mes-clients', function () {
//     return view('mes-clients');
// });
// Route::get('/listes-apprenants', function () {
//     return view('listes-apprenants');
// });
// Route::get('/mes-apprenants', function () {
//     return view('mes-apprenants');
// });
// Route::get('/profil-apprenant', function () {
//     return view('profil-apprenants');
// });

