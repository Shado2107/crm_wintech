@extends('layouts.default')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@section('content')
<div class="content-add-parcours">
                <style>
                    .nmj:hover{
                        background-color:#9045e2;
                        color:white;
                        border-radius:100px;
                    }
                </style>
   
    
    <div class="content-form">
    <form action="{{route('store_projet_2', $projet->id)}}" method="post" class="form-horizontal" id="demo1-upload" enctype="multipart/form-data">
                                    {{ csrf_field() }}
            

           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           <input type="hidden" name="token" id="token" value="{{ Illuminate\Support\Str::random(155) }}" aria-describedby="name" placeholder="">

            <div class="form-one Setp">
               <div class="head-form">
                   <h2>Etape 2 ajouter un projet</h2>
                   
               </div>
                <div class="step1e">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-element-2">
                            <!-- <p class="title">Formation : </p>-->
                            <p class="text-description">2. Information du personnel</p>
        
                                  
                                <div class="form-group">
                                    <label for="name" style="color:black;">2.1Nombre d'emplois(saisir le nombre d'employés)<span style="color:red">*</span> : </label>
                                    <input required type="number" class="form-control" id="name" name="nbre_employer" aria-describedby="name" placeholder="">
                                </div>
                               
                               <p class="text-description">2.2 Sexe</p>
                               
                                <div class="form-group">
                                    <label for="name" style="color:black;">Nombre d'hommes<span style="color:red">*</span> : </label>
                                    <input required type="number" class="form-control" id="name" name="nbre_homme" aria-describedby="name" placeholder="">
                                </div>
                                
                                <div class="form-group">
                                    <label for="name" style="color:black;">Nombre de femmes<span style="color:red">*</span> : </label>
                                    <input required type="number" class="form-control" id="name" name="nbre_femme" aria-describedby="name" placeholder="">
                                </div>
                                
                                <div class="form-group">
                                    <label for="name" style="color:black;">Nombre de jeunes (-35ans)<span style="color:red">*</span> : </label>
                                    <input required type="number" class="form-control" id="name" name="nbre_jeune" aria-describedby="name" placeholder="">
                                </div>
                                
                                 <div class="form-group">
                                    <label for="name" style="color:black;">Nombre de personnes handicapées<span style="color:red">*</span> : </label>
                                    <input required type="number" class="form-control" id="name" name="nbre_perso_handicap" aria-describedby="name" placeholder="">
                                </div>
                                
                                <!-- <p class="text-description">2.3 Nationalité du personnel dans votre organisation</p>-->
                                                   
                                <!--   <div class="form-group">-->
                                <!--    <label for="name" style="color:black;">Expartié<span style="color:red">*</span> : </label>-->
                                <!--    <input required type="number" class="form-control" id="name" name="nbre_expertie" aria-describedby="name" placeholder="Nombre">-->
                                <!--</div>-->
                                
                                <!-- <div class="form-group">-->
                                <!--        <label for="name" style="color:black;">National<span style="color:red">*</span> : </label>-->
                                <!--    <input required type="number" class="form-control" id="name" name="nbre_national" aria-describedby="name" placeholder="Nombre">-->
                                <!--</div>-->
                                
                                <!--<p class="text-description">2.4 Statut</p>-->
                                
                                <!--<div class="form-group">-->
                                <!--    <label for="name" style="color:black;">Nombre temporaire<span style="color:red">*</span> : </label>-->
                                <!--    <input required type="number" class="form-control" id="name" name="nbre_temporaire" aria-describedby="name" placeholder="">-->
                                <!--</div>-->
                                
                                <!-- <div class="form-group">-->
                                <!--    <label for="name" style="color:black;">Nombre permenant<span style="color:red">*</span> : </label>-->
                                <!--    <input required type="number" class="form-control" id="name" name="nbre_permenant" aria-describedby="name" placeholder="">-->
                                <!--</div>-->
                                

                                <!--   <div class="form-group">-->
                                <!--    <label for="name" style="color:black;">Nombre Volontaire<span style="color:red">*</span> : </label>-->
                                <!--    <input required type="number" class="form-control" id="name" name="nbre_volontaire" aria-describedby="name" placeholder="Nombre">-->
                                <!--</div>-->
                                
                                <!-- <div class="form-group">-->
                                <!--        <label for="name" style="color:black;">Nombre stagiare<span style="color:red">*</span> : </label>-->
                                <!--    <input required type="number" class="form-control" id="name" name="nbre_stagiare" aria-describedby="name" placeholder="Nombre">-->
                                <!--</div>-->
                  
                        </div>
                    </div>

                    
                </div>
                </div>
              

               <!--<div type="button" class="btn btn-poursuivre" data-toggle="modal" data-target="#parcoursModal">-->
               <!--         Terminer-->
               <!--     </div>-->
                <button type="submit" class="btn btn-poursuivre">Suivant</button>
            </div>

 <!-- Modal -->
                 
                


                </div>

            </div>


        </form>


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
