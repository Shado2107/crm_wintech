@extends('layouts.default')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@section('content')
<div class="content-add-parcours">
                <style>
                    .nmj:hover{
                        background-color:lightgray;
                        color:white;
                        border-radius:100px;
                    }
                    .content-form{
                        background-color:lightgray;
                    }
                </style>
   
  

    <div class="content-form">
   <h2>{{$projet->libelle}}</h2>

<table style="width:100%">
    
  <tr>
    <th>1. Identification</th>
  </tr>
  <tr>
    <td>1.1 Nom de l'organisation : <b>{{$projet->libelle}}</b></td>
    <td>1.2 Statut : @if($projet->statut == 0) <b>Association</b> @else <b>ONG</b> @endif</td>
    <td>1.3 type : @if($projet->type == 0) National @else <b>International</b> @endif </td>
  </tr>
  
   <tr>
    <th>1.3 Zone d'intervention</th>
  </tr>
  <tr>
    <td>1.3.1 Région : <b>{{$projet->region}}</b></td>
    <td>1.3.2 Département : <b>{{$projet->departement}}</b></td>
  </tr>
  
  <tr>
    <th>2. Information du personnel</th>
  </tr>
  <tr>
    <td>2.1Nombre d'emplois(saisir le nombre d'employés) : <b>{{$projet->nbre_employer}}</b></td>
    <tr>
    <td>2.2 Sexe : </td>
    <tr>
    <td>Nombre d'hommes : <b>{{$projet->nbre_homme}}</b></td>
    <td>Nombre de femmes : <b>{{$projet->nbre_femme}}</b></td>
    <td>Nombre de jeunes (-35ans) : <b>{{$projet->nbre_jeune}}</b></td>
    <td>Nombre de personnes handicapées : <b>{{$projet->nbre_perso_handicap}}</b></td>
    </tr>
    </tr>
  </tr>
  
   <tr>
    <th>2.3 Nationalité du personnel dans votre organisation</th>
  </tr>
  <tr>
    <td>Expartié : <b>{{$projet->nbre_expertie}}</b></td>
    <td>National : <b>{{$projet->nbre_national}}</b></td>
    <tr>
    <td>2.4 Statut : </td>
    <tr>
    <td>Nombre temporaire : <b>{{$projet->nbre_temporaire}}</b></td>
    <td>Nombre permenant : <b>{{$projet->nbre_permenant}}</b></td>
    <td>Nombre Volontaire : <b>{{$projet->nbre_volontaire}}</b></td>
    <td>Nombre stagiare : <b>{{$projet->nbre_stagiare}}</b></td>
    </tr>
    </tr>
  </tr>
  
   <tr>
    <th>3.1 Secteur d'intervention et investissement financier</th>
  </tr>
  @php 
  
  $sec_inters = DB::table('secteur_intervention_projets')->select('secteur_intervention_projets.*', 
  'projets.id as ID', 'secteur_interventions.libelle', 'secteur_interventions.id as Id')
  ->join('secteur_interventions', 'secteur_interventions.id', 'secteur_intervention_projets.secteur_id')
  ->join('projets', 'projets.id', 'secteur_intervention_projets.projet_id')
  ->where('secteur_intervention_projets.projet_id', $projet->id)
  ->OrderBy('secteur_intervention_projets.id', 'desc')
  ->get();
 
  @endphp
  <tr>
     <tr>
    <td>Secteur d'intervention et investissement financier : </td>
    @foreach($sec_inters as $sec_inter)
     <tr>
    <td>Secteur :  <b>{{$sec_inter->libelle}}</b></td>
    </tr>
    @endforeach
    </tr>
  </tr>
  
   <tr>
    <th>3.2 Nombre de projets implémentés</th>
  </tr>
   @php 
  
  $sec_implets = DB::table('secteur_implementations')->select('secteur_implementations.*', 
  'projets.id as ID')
  ->join('projets', 'projets.id', 'secteur_implementations.projet_id')
  ->where('secteur_implementations.projet_id', $projet->id)
  ->OrderBy('secteur_implementations.id', 'desc')
  ->get();
   DB::table('secteur_implementations')->where('projet_id', $projet->id)->where('nombre', NULL)->delete();
  @endphp
   <tr>
     <tr>
    <td>Projets implémentés : </td>
     @foreach($sec_implets as $sec_implet)
     <tr>
    <td>libelle : <b>{{$sec_implet->libelle}}</b></td>
    <td>Nombre : <b>{{$sec_implet->nombre}}</b></td>
    </tr>
     @endforeach
    </tr>
  </tr>
  
  <tr>
    <th>3.3 Montant en FCFA par secteur investissement directe (saisir le montant en chiffres en FCFA)</th>
  </tr>
   @php 
  
  $sec_invests = DB::table('secteur_investissements')->select('secteur_investissements.*', 
  'projets.id as ID')
  ->join('projets', 'projets.id', 'secteur_investissements.projet_id')
  ->where('secteur_investissements.projet_id', $projet->id)
  ->OrderBy('secteur_investissements.id', 'desc')
  ->get();
  DB::table('secteur_investissements')->where('projet_id', $projet->id)->where('montant', NULL)->delete();
  @endphp
   <tr>
     <tr>
    <td>le montant en chiffres en FCFA : </td>
     @foreach($sec_invests as $sec_invest)
     <tr>
    <td>libelle : <b>{{$sec_invest->libelle}}</b></td>
     <td>Montant : <b>{{$sec_invest->montant}}</b></td>
    </tr>
    @endforeach
    </tr>
  </tr>
  
  <tr>
    <th>3.4 Origines des ressources financièrs</th>
  </tr>
   <tr>
     <tr>
    <td>Montant mobilisé au niveau national : <b>{{$projet->montant_national}}</b></td>
    </tr>
     <tr>
    <td>Montant mobilisé au niveau international : <b>{{$projet->montant_international}}</b></td>
    </tr>
     <tr>
    <td>Montant sur fonds propres : <b>{{$projet->montant_fond}}</b></td>
    </tr>
     <tr>
    </tr>
  </tr>
  
   <tr>
    <th>Montant contribution des partenaires financiers UE et pays membres</th>
  </tr>
   <tr>
    <td>UE :  <b>{{$projet->ue_mnt_contribution}}</b></td>
    <td>Pays membres :  <b>{{$projet->pays_membre}}</b></td>
    <td>USAID :  <b>{{$projet->usaid}}</b></td>
    <td>ACDI / Canada :  <b>{{$projet->acdi_canada}}</b></td>
    <td>Pays arabes :  <b>{{$projet->pays_arabe}}</b></td>
    </tr>
   
    <tr>
    <th>4. Realisation par secteur investissement directe</th>
  </tr>
  
   @php 
  
  $sec_realis = DB::table('secteur_realisations')->select('secteur_realisations.*', 
  'projets.id as ID')
  ->join('projets', 'projets.id', 'secteur_realisations.projet_id')
  ->where('secteur_realisations.projet_id', $projet->id)
  ->OrderBy('secteur_realisations.id', 'desc')
  ->get();
  DB::table('secteur_realisations')->where('projet_id', $projet->id)->where('realiser', NULL)->delete();
  @endphp
   <tr>
     <tr>
    <td>Investissement directe : </td>
      @foreach($sec_realis as $sec_reali)
     <tr>
    <td>libelle : <b>{{$sec_reali->libelle}}</b></td>
     <td>Réalisation : <b>{{$sec_reali->realiser}}</b></td>
    </tr>
    @endforeach
    </tr>
  </tr>
  
   <tr>
    <th>Personnes beneficiaires ou touches</th>
  </tr>
   <tr>
    <td>Nombre d'hommes : <b>{{$projet->nbre_homme_benefit}}</b></td>
    <td>Nombre de femmes : <b>{{$projet->nbre_femme_benefit}}</b></td>
    <td>Nombre de jeunes : <b>{{$projet->nbre_jeune_benefit}}</b></td>
    <td>Nombre de personnes handicapées : <b>{{$projet->nbre_handicap_benefit}}</b></td>
    </tr>
   <tr>
    <th>Contacts</th>
  </tr>
   @php 
  
  $contact = DB::table('contacts')->select('contacts.*', 
  'contacts.id as ID')
  ->join('projets', 'projets.id', 'contacts.projet_id')
  ->where('contacts.projet_id', $projet->id)
  ->OrderBy('contacts.id', 'desc')
  ->first();
 
  @endphp
  @if($contact)
   <tr>
     <tr>
    <td>Prénom : <b>{{$contact->prenom}}</b></td>
    </tr>
     <tr>
    <td>Nom : <b>{{$contact->nom}}</b></td>
    </tr>
     <tr>
    <td>Email : <b>{{$contact->email}}</b></td>
    </tr>
     <tr>
    <td>Phone : <b>{{$contact->phone}}</b></td>
    </tr>
  </tr>
  @endif
</table>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

@if(!empty(Session::get('error_code')) && Session::get('error_code') 
 == 5)
  <script>
    $(function() {
      $('#parcoursModal').modal('show');
    });
</script>
@endif

<script>

var groupA=$("input[type='checkbox'].single-checkbox1");
groupA.click(function(e) {
  if (groupA.filter(":checked").length > 1)
      e.preventDefault();
  }
);

var groupB=$("input[type='checkbox'].single-checkbox2");
groupB.click(function(e) {
  if (groupB.filter(":checked").length > 1)
      e.preventDefault();
  }
);

var groupC=$("input[type='checkbox'].single-checkbox3");
groupC.click(function(e) {
  if (groupC.filter(":checked").length > 1)
      e.preventDefault();
  }
);

var groupD=$("input[type='checkbox'].single-checkbox4");
groupD.click(function(e) {
  if (groupD.filter(":checked").length > 1)
      e.preventDefault();
  }
);

var groupE=$("input[type='checkbox'].single-checkbox5");
groupE.click(function(e) {
  if (groupE.filter(":checked").length > 1)
      e.preventDefault();
  }
);
    
       $("#step2b").hide();
        $("#step3b").hide();
        $(".step2").hide();
        $(".step3").hide();

    $("#step1b").click(function(){
        $("#step2b").show();
        $("#step3b").hide();
        $("#step1b").hide();
        $(".step1").show();
        $(".step2").show();
        $(".step3").hide();
    });

    $("#step2b").click(function(){
        $("#step2b").hide();
        $("#step3b").show();
        $("#step1b").hide();
        $(".step2").show();
        $(".step3").show();
        $(".step1").show();
    });


    

</script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>

FilePond.registerPlugin(
 
  FilePondPluginFileValidateSize
);
const inputElement = document.querySelector('input[type="file"]');
const pond = FilePond.create( inputElement );

    var token = $("#token").val();
    
    
    FilePond.setOptions({
        server: {
            url: '/filepond',
            headers: {
                
                'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                'X-TOKEN': token,
            }
        }
    });
    
    @if (session()->has('message'))
    <script>
        $('#parcoursModal').modal('toggle');
    </script>
@endif

</script>

<style> 
    .text-information {
        font-size : 24px;
    }

</style>
@stop
