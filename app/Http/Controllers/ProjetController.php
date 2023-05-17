<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Mail; 
use Illuminate\Contracts\Encryption\DecryptException;
use Crypt;
use Illuminate\Support\Str;

use App\Models\Projet;
use App\Models\Contact;
use App\Models\Secteur_realisation;
use App\Models\Secteur_intervention;
use App\Models\Secteur_projet;
use App\Models\Secteur_investissement;
use App\Models\Secteur_implementation;


use Illuminate\Validation\Rule;
use RahulHaque\Filepond\Facades\Filepond;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\RegistersUsers;
use File;
use Flash;



class ProjetController extends Controller
{
    //
    
    
     public function lister_projets()
    {
        $projets = DB::table('projets')->orderBy('id', 'desc')->get();
        return view('projet/lister_projets', compact('projets'));
    }
    
     public function editer_projet_1($id)
    {
        $projet = Projet::findOrFail($id);
        return view('projet/editer.editer_projet_1' , compact('projet'));
    }
    
    
    
    
     public function update_projet_1(Request $request, $id)
    {
        
        $message = "Etape 1 Modifié avec succès";


        $projet = Projet::findOrFail($id);
        $projet->libelle = $request->get('libelle');
        $projet->statut = $request->get('statut'); 
        $projet->type = $request->get('type'); 
        $projet->region = $request->get('region'); 
        $projet->departement = $request->get('type'); 
        $projet->save();

        return redirect()->route('editer_projet_2', [$projet->id])->with(['message' => $message]);
 
    }
    
    
     public function editer_projet_2($id)
    {
        $projet = Projet::findOrFail($id);
        return view('projet/editer.editer_projet_2', compact('projet'));
    }
    
    
     public function update_projet_2(Request $request, $id)
    {
        
        $message = "Etape 2 Modifié avec succès";

        $projet = Projet::findOrFail($id);
        $projet->nbre_employer = $request->get('nbre_employer');
        $projet->nbre_homme = $request->get('nbre_homme'); 
        $projet->nbre_femme = $request->get('nbre_femme'); 
        $projet->nbre_jeune = $request->get('nbre_jeune'); 
        $projet->nbre_perso_handicap = $request->get('nbre_perso_handicap'); 
        $projet->save();

        return redirect()->route('editer_projet_3', [$projet->id])->with(['message' => $message]);

 
    }
    
     public function editer_projet_3($id)
    {
        
         $projet = Projet::find($id);
        return view('projet/editer.editer_projet_3', compact('projet'));
    }
    
    
     public function update_projet_3(Request $request, $id)
    {
        
        $message = "Etape 3 Modifié avec succès";

        $projet = Projet::findOrFail($id);
        $projet->nbre_expertie = $request->get('nbre_expertie');
        $projet->nbre_national = $request->get('nbre_national'); 
        $projet->nbre_temporaire = $request->get('nbre_temporaire'); 
        $projet->nbre_permenant = $request->get('nbre_permenant'); 
        $projet->nbre_volontaire = $request->get('nbre_volontaire'); 
        $projet->nbre_stagiare = $request->get('nbre_stagiare'); 
        $projet->save();

        return redirect()->route('editer_projet_4', [$projet->id])->with(['message' => $message]);
    }


    public function editer_projet_4($id)
    {
        
         $projet = Projet::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet/editer.editer_projet_4', compact('projet', 'secteurs'));
    }
    
    
     public function update_projet_4(Request $request, $id)
    {
        
        $message = "Etape 5 Modifié avec succès";

        $projet = Projet::findOrFail($id);
        $projet->autre_intervention = $request->get('autre_intervention');
        $projet->autre_montant = $request->get('autre_montant');
        $projet->save();


        

        return redirect()->route('editer_projet_5', [$projet->id])->with(['message' => $message]);
 
    }
    
    public function editer_projet_5($id)
    {
        
         $projet = Projet::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet/editer.editer_projet_5', compact('projet', 'secteurs'));
    }
    
    
     public function update_projet_5(Request $request, $id)
    {
        
        $message = "Etape 5 Modifié avec succès";

       $projet = Projet::findOrFail($id);
        $projet->montant_national = $request->get('montant_national'); 
        $projet->montant_international = $request->get('montant_international'); 
        $projet->montant_fond = $request->get('montant_fond'); 
        $projet->ue_mnt_contribution = $request->get('ue_mnt_contribution'); 
        $projet->pays_membre = $request->get('pays_membre'); 
        $projet->usaid = $request->get('usaid'); 
        $projet->acdi_canada = $request->get('acdi_canada'); 
        $projet->pays_arabe = $request->get('pays_arabe'); 
        $projet->autre_origine = $request->get('autre_origine'); 
        $projet->save();

        

        return redirect()->route('editer_projet_6', [$projet->id])->with(['message' => $message]);
 
    }
    
    
    
    
    public function editer_projet_6($id)
    {
        
         $projet = Projet::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet/editer.editer_projet_6', compact('projet', 'secteurs'));
    }
    
    
     public function update_projet_6(Request $request, $id)
    {
        
        $message = "Etape 6 Modifié avec succès";

        $projet = Projet::findOrFail($id);
        $projet->nbre_homme_benefit = $request->get('nbre_homme_benefit');
        $projet->nbre_femme_benefit = $request->get('nbre_femme_benefit');
        $projet->nbre_jeune_benefit = $request->get('nbre_jeune_benefit');
        $projet->nbre_handicap_benefit = $request->get('nbre_handicap_benefit');
        $projet->save();

       

        

        return redirect('/lister_projets')->with(['message' => $message]);
 
    }
    
    
    
    
    public function editer_secteur_projet($id)
    {
        
         $projet = Secteur_projet::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet/editer.editer_secteur_projet', compact('projet', 'secteurs'));
    }
    
    
     public function update_secteur_projet(Request $request, $id)
    {
        
        $message = "Etape 5 Modifié avec succès";

        $projet = Secteur_projet::findOrFail($id);
        $projet->secteur_id = $request->get('secteur_id');
        $projet->save();


        

        return redirect()->route('editer_projet_4', [$projet->projet_id])->with(['message' => $message]);
 
    }
    
    public function editer_secteur_imple($id)
    {
        
         $projet = Secteur_implementation::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet/editer.editer_secteur_imple', compact('projet', 'secteurs'));
    }
    
    
     public function update_secteur_imple(Request $request, $id)
    {
        
        $message = "Etape 5 Modifié avec succès";

        $projet = Secteur_implementation::findOrFail($id);
        $projet->libelle = $request->get('libelle');
        $projet->nombre = $request->get('nombre');
        $projet->save();


        

        return redirect()->route('editer_projet_4', [$projet->projet_id])->with(['message' => $message]);
 
    }
    
    public function editer_secteur_investi($id)
    {
        
         $projet = Secteur_investissement::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet/editer.editer_secteur_investi', compact('projet', 'secteurs'));
    }
    
    
     public function update_secteur_investi(Request $request, $id)
    {
        
        $message = "Etape 5 Modifié avec succès";

        $projet = Secteur_investissement::findOrFail($id);
        $projet->libelle = $request->get('libelle');
        $projet->montant = $request->get('montant');
        $projet->save();


        

        return redirect()->route('editer_projet_4', [$projet->projet_id])->with(['message' => $message]);
 
    }
    
    public function editer_secteur_realiser($id)
    {
        
         $projet = Secteur_realisation::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet/editer.editer_secteur_realiser', compact('projet', 'secteurs'));
    }
    
    
     public function update_secteur_realiser(Request $request, $id)
    {
        
        $message = "Etape 5 Modifié avec succès";

        $projet = Secteur_realisation::findOrFail($id);
        $projet->libelle = $request->get('libelle');
        $projet->realiser = $request->get('realiser');
        $projet->save();


        

        return redirect()->route('editer_projet_6', [$projet->projet_id])->with(['message' => $message]);
 
    }
    
    //////////////////////////// editer
    
     public function details_projet($id)
    {
         $projet = Projet::findOrFail($id);
        return view('projet/show.projets_details', compact('projet'));
    }
    
     public function create_projet_1()
    {
        
        return view('projet/create_projet_1');
    }
    
       public function store_projet_1(Request $request)
    {
        
        $message = "Etape 1 ajouté avec succès";


        $projet = new Projet;
        $projet->libelle = $request->get('libelle');
        $projet->statut = $request->get('statut'); 
        $projet->type = $request->get('type'); 
        $projet->region = $request->get('region'); 
        $projet->departement = $request->get('type'); 
        $projet->save();

        return redirect()->route('create_projet_2', [$projet->id])->with(['message' => $message]);
 
    }
    
    
     public function create_projet_2($id)
    {
        $projet = Projet::find($id);
        return view('projet.create_projet_2', compact('projet'));
    }
    
    
     public function store_projet_2(Request $request, $id)
    {
        
        $message = "Etape 2 ajouté avec succès";

        $projet = Projet::findOrFail($id);
        $projet->nbre_employer = $request->get('nbre_employer');
        $projet->nbre_homme = $request->get('nbre_homme'); 
        $projet->nbre_femme = $request->get('nbre_femme'); 
        $projet->nbre_jeune = $request->get('nbre_jeune'); 
        $projet->nbre_perso_handicap = $request->get('nbre_perso_handicap'); 
        $projet->save();

        return redirect()->route('create_projet_3', [$projet->id])->with(['message' => $message]);

 
    }
    
     public function create_projet_3($id)
    {
        
         $projet = Projet::find($id);
        return view('projet.create_projet_3', compact('projet'));
    }
    
    
     public function store_projet_3(Request $request, $id)
    {
        
        $message = "Etape 3 ajouté avec succès";

        $projet = Projet::findOrFail($id);
        $projet->nbre_expertie = $request->get('nbre_expertie');
        $projet->nbre_national = $request->get('nbre_national'); 
        $projet->nbre_temporaire = $request->get('nbre_temporaire'); 
        $projet->nbre_permenant = $request->get('nbre_permenant'); 
        $projet->nbre_volontaire = $request->get('nbre_volontaire'); 
        $projet->nbre_stagiare = $request->get('nbre_stagiare'); 
        $projet->save();

        return redirect()->route('create_projet_4', [$projet->id])->with(['message' => $message]);
    }
    
    public function create_projet_4($id)
    {
        
         $projet = Projet::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet.create_projet_4', compact('projet', 'secteurs'));
    }
    
    
     public function store_projet_4(Request $request, $id)
    {
        
        $message = "Etape 4 ajouté avec succès";

        $projet = Projet::findOrFail($id);
        $projet->autre_intervention = $request->get('autre_intervention');
        $projet->autre_montant = $request->get('autre_montant');
        $projet->save();

        $secteur_id = $request->get('secteur_id');
        $projet_id = $request->get('projet_id');

                 for($i=0; $i < count($secteur_id); $i++){
                 $secteur_projets = [
                    
                     'secteur_id' => $secteur_id[$i],
                     'projet_id' => $projet->id,

                    ];
                     
                     DB::table('secteur_intervention_projets')->insert($secteur_projets);
                 }
                 
        $libelle = $request->get('libelle');
        $nombre = $request->get('nombre');

                 for($i=0; $i < count($libelle); $i++){
                 $secteur_implementation = [
                    
                     'libelle' => $libelle[$i],
                     'nombre' => $nombre[$i],
                     'projet_id' => $projet->id,

                    ];
                     
                     DB::table('secteur_implementations')->insert($secteur_implementation);
                 }
        
        $libelleM = $request->get('libelleM');
        $montant = $request->get('montant');

                 for($i=0; $i < count($libelleM); $i++){
                 $secteur_investissement = [
                    
                     'libelle' => $libelleM[$i],
                     'montant' => $montant[$i],
                     'projet_id' => $projet->id,

                    ];
                     
                     DB::table('secteur_investissements')->insert($secteur_investissement);
                 }

        

        return redirect()->route('create_projet_5', [$projet->id])->with(['message' => $message]);
 
    }


public function create_projet_5($id)
    {
        
         $projet = Projet::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet.create_projet_5', compact('projet', 'secteurs'));
    }
    
    
     public function store_projet_5(Request $request, $id)
    {
        
        $message = "Etape 5 ajouté avec succès";

       $projet = Projet::findOrFail($id);
        $projet->montant_national = $request->get('montant_national'); 
        $projet->montant_international = $request->get('montant_international'); 
        $projet->montant_fond = $request->get('montant_fond'); 
        $projet->ue_mnt_contribution = $request->get('ue_mnt_contribution'); 
        $projet->pays_membre = $request->get('pays_membre'); 
        $projet->usaid = $request->get('usaid'); 
        $projet->acdi_canada = $request->get('acdi_canada'); 
        $projet->pays_arabe = $request->get('pays_arabe'); 
        $projet->autre_origine = $request->get('autre_origine'); 
        $projet->save();

        

        return redirect()->route('create_projet_6', [$projet->id])->with(['message' => $message]);
 
    }
    
    public function create_projet_6($id)
    {
        
         $projet = Projet::find($id);
         $secteurs = DB::table('secteur_interventions')->orderBy('id', 'asc')->get();
        return view('projet.create_projet_6', compact('projet', 'secteurs'));
    }
    
    
     public function store_projet_6(Request $request, $id)
    {
        
        $message = "Etape 6 ajouté avec succès";

        $projet = Projet::findOrFail($id);
        $projet->nbre_homme_benefit = $request->get('nbre_homme_benefit');
        $projet->nbre_femme_benefit = $request->get('nbre_femme_benefit');
        $projet->nbre_jeune_benefit = $request->get('nbre_jeune_benefit');
        $projet->nbre_handicap_benefit = $request->get('nbre_handicap_benefit');
        $projet->save();

        $libelle = $request->get('libelle');
        $realiser = $request->get('realiser');
        $projet_id = $request->get('projet_id');

                 for($i=0; $i < count($libelle); $i++){
                 $secteur_realisation = [
                    
                     'libelle' => $libelle[$i],
                     'realiser' => $realiser[$i],
                     'projet_id' => $projet->id,

                    ];
                     
                     DB::table('secteur_realisations')->insert($secteur_realisation);
                 }
                 
        $contact = new Contact;
        $contact->prenom = $request->get('prenom');
        $contact->nom = $request->get('nom');
        $contact->email = $request->get('email');
        $contact->phone = $request->get('phone');
        $contact->projet_id = $projet->id;
        $contact->save();

        

        return back()->with(['message' => $message]);
 
    }
    
     public function delete_projet($id)
    {
        $message = "Projet a été supprimé avec succès";
         $projet = Projet::find($id);
         
         DB::table('secteur_intervention_projets')->where('projet_id', $projet->id)->delete();
         DB::table('secteur_investissements')->where('projet_id', $projet->id)->delete();
         DB::table('secteur_realisations')->where('projet_id', $projet->id)->delete();
         DB::table('secteur_implementations')->where('projet_id', $projet->id)->delete();
         DB::table('contacts')->where('projet_id', $projet->id)->delete();
         
         $projet->delete();

         return back()->with(['message' => $message]);
    }

}

  