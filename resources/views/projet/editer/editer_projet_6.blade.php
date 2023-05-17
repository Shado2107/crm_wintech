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
   
     <h6> 
              @if (session('message'))
                  <div class="alert alert-success" style="background-color:lightgreen" role="alert">
                      {{ session('message') }}
                  </div>  
              @endif
            </h6>
    <div class="content-form">
    <form action="{{route('update_projet_6', $projet->id)}}" method="post" class="form-horizontal" id="demo1-upload" enctype="multipart/form-data">
                                    {{ csrf_field() }}
            

           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           <input type="hidden" name="token" id="token" value="{{ Illuminate\Support\Str::random(155) }}" aria-describedby="name" placeholder="">

            <div class="form-one Setp">
               <div class="head-form">
                   <h2>Etape 6 ajouter un projet</h2>
                   
               </div>
                <div class="step1e">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-element-2">

                               
                              <p class="text-description">4. Réalisation par secteur investissement directe</p> 
                                <div class="form-group" style="color:black;">
                                                 @php 
                                                  
                                                  $sec_realis = DB::table('secteur_realisations')->select('secteur_realisations.*', 
                                                  'projets.id as ID')
                                                  ->join('projets', 'projets.id', 'secteur_realisations.projet_id')
                                                  ->where('secteur_realisations.projet_id', $projet->id)
                                                  ->OrderBy('secteur_realisations.id', 'desc')
                                                  ->get();
                                                  DB::table('secteur_realisations')->where('projet_id', $projet->id)->where('realiser', NULL)->delete();
                                                  @endphp
                                                <table>
                                                  <tr>
                                                    <th>Realisation par secteur </th>
                                                    <th>Réalisés </th>
                                                    <th>Options</th>
                                                  </tr>
                                                  @foreach($sec_realis as $sec_reali)
                                                  <tr>
                                                    <td>{{$sec_reali->libelle}}</td>
                                                    <td>{{$sec_reali->realiser}}</td>
                                                    <td><a href="{{route('editer_secteur_realiser', $sec_reali->id)}}">Modifier</a>
                                                  </tr>
                                                 @endforeach
                                                </table>
                                    <!--<div class="group-select-challanges">-->
                                        
                                    <!--    <div class="form-group-radio">-->
                                    <!--        <input type="checkbox" class="single" id="cdh" onclick="myFunctioncdh()" >-->
                                    <!--        <label class="label-radio" for="image" style="color:black;">CDH</label>-->
                                    <!--    </div>-->
                                        
                                    <!--    <div class="form-group-radio" id="cdh1">-->
                                    <!--        <label for="name" style="color:black;">Donner le nombre : </label>-->
                                    <!--        <input type="hidden" class="single" name="libelle[]" value="CDH">-->
                                    <!--        <input type="number" class="single"  name="realiser[]">-->
                                    <!--    </div>-->
                                        
                                    <!--     <div class="form-group-radio">-->
                                    <!--        <input type="checkbox" class="single" id="idu" onclick="myFunctionidu()">-->
                                    <!--        <label class="label-radio" for="image" style="color:black;">IDU</label>-->
                                    <!--    </div>-->
                                        
                                    <!--    <div class="form-group-radio" id="idu1">-->
                                    <!--        <label for="name" style="color:black;">Donner le nombre : </label>-->
                                    <!--        <input type="hidden" class="single"  name="libelle[]" value="IDU">-->
                                    <!--        <input type="number" class="single"  name="realiser[]">-->
                                    <!--    </div>-->
                                        
                                        
                                    <!--    <div class="form-group-radio">-->
                                    <!--        <input type="checkbox" class="single" id="sc"  onclick="myFunctionsc()">-->
                                    <!--        <label class="label-radio" for="image" style="color:black;">SC</label>-->
                                    <!--    </div>-->
                                        
                                    <!--    <div class="form-group-radio" id="sc1">-->
                                    <!--        <label for="name" style="color:black;">Donner le nombre : </label>-->
                                    <!--        <input type="hidden" class="single"  name="libelle[]" value="SC">-->
                                    <!--        <input type="number" class="single"  name="realiser[]">-->
                                    <!--    </div>-->
                                        
                                    <!--    <div class="form-group-radio">-->
                                    <!--        <input type="checkbox" class="single" id="cas" onclick="myFunctioncas()" >-->
                                    <!--        <label class="label-radio" for="image" style="color:black;">CAS</label>-->
                                    <!--    </div>-->
                                        
                                    <!--    <div class="form-group-radio" id="cas1">-->
                                    <!--        <label for="name" style="color:black;">Donner le nombre : </label>-->
                                    <!--        <input type="hidden" class="single"  name="libelle[]" value="CAS">-->
                                    <!--        <input type="number" class="single"  name="realiser[]">-->
                                    <!--    </div>-->
                                        
                                    <!--    <div class="form-group-radio">-->
                                    <!--        <input type="checkbox" class="single" id="asap" onclick="myFunctionasap()" >-->
                                    <!--        <label class="label-radio" for="image" style="color:black;">ASAP</label>-->
                                    <!--    </div>-->
                                        
                                    <!--    <div class="form-group-radio" id="asap1">-->
                                    <!--        <label for="name" style="color:black;">Donner le nombre : </label>-->
                                    <!--        <input type="hidden" class="single"  name="libelle[]" value="ASAP">-->
                                    <!--        <input type="number" class="single"  name="realiser[]">-->
                                    <!--    </div>-->
                                        
                                    <!--</div>-->
                                </div>
                                
                                  <p class="text-description">Personnes beneficiaires ou touches</p>
                                   <div class="form-group" id="autre">
                                    <label for="name" style="color:black;">Nombre d'hommes </label>
                                    <input type="text" class="form-control" value="{{$projet->nbre_homme_benefit}}" id="name" name="nbre_homme_benefit" aria-describedby="name" placeholder="">
                                  </div>
                                  
                                  <div class="form-group" id="autre">
                                    <label for="name" style="color:black;">Nombre de femmes </label>
                                    <input type="text" class="form-control" id="name" value="{{$projet->nbre_femme_benefit}}" name="nbre_femme_benefit" aria-describedby="name" placeholder="">
                                  </div>
                                  
                                  <div class="form-group" id="autre">
                                    <label for="name" style="color:black;">Nombre de jeunes </label>
                                    <input type="text" class="form-control" id="name" name="nbre_jeune_benefit" value="{{$projet->nbre_jeune_benefit}}" aria-describedby="name" placeholder="">
                                  </div>
                                  
                                  <div class="form-group" id="autre">
                                    <label for="name" style="color:black;">Nombre de personnes handicapées </label>
                                    <input type="text" class="form-control" id="name" name="nbre_handicap_benefit" value="{{$projet->nbre_handicap_benefit}}" aria-describedby="name" placeholder="">
                                  </div>
                                
                              
                                 <!--<p class="text-description">Soubmission</p>-->
                                 <!--  <div class="form-group" id="autre">-->
                                 <!--   <label for="name" style="color:black;">Prénom</label>-->
                                 <!--   <input type="text" class="form-control" id="name" name="prenom" aria-describedby="name" placeholder="">-->
                                 <!-- </div>-->
                                  
                                 <!-- <div class="form-group" id="autre">-->
                                 <!--   <label for="name" style="color:black;">Nom</label>-->
                                 <!--   <input type="text" class="form-control" id="name" name="nom" aria-describedby="name" placeholder="">-->
                                 <!-- </div>-->
                                  
                                 <!-- <div class="form-group" id="autre">-->
                                 <!--   <label for="name" style="color:black;">Email </label>-->
                                 <!--   <input type="text" class="form-control" id="name" name="email" aria-describedby="name" placeholder="">-->
                                 <!-- </div>-->
                                  
                                 <!-- <div class="form-group" id="autre">-->
                                 <!--   <label for="name" style="color:black;">Phone</label>-->
                                 <!--   <input type="text" class="form-control" id="name" name="phone" aria-describedby="name" placeholder="">-->
                                 <!-- </div>-->
                                
                  
                        </div>
                    </div>

                    
                </div>
                </div>
              

               <!--<div type="button" class="btn btn-poursuivre" data-toggle="modal" data-target="#parcoursModal">-->
               <!--         Terminer-->
               <!--     </div>-->
                <button type="submit" class="btn btn-poursuivre">Enregistrer</button>
            </div>

 <!-- Modal -->
                 
                
<p id="text" style="display:none">Checkbox is CHECKED!</p>


                </div>

            </div>


        </form>


    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


<script>
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("text");
  if (checkBox.checked == 'GDH'){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}
</script>

@if(!empty(Session::get('error_code')) && Session::get('error_code') 
 == 5)
  <script>
    $(function() {
      $('#parcoursModal').modal('show');
    });
</script>
@endif

<script>

$('.check_box').change(function(){
if($('.check_box:checked').length==0){
    $('.p_element').show(); //Show all,when nothing is checked
}else{
    $('.p_element').hide();
    $('.check_box:checked').each(function(){
        $('#'+$(this).attr('data-ptag')).show();
    });
  }

});

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
    
       $("#cdh1").hide();
       $("#idu1").hide();
       $("#sc1").hide();
       $("#cas1").hide();
       $("#asap1").hide();
       
       $("#cdh1M").hide();
       $("#idu1M").hide();
       $("#sc1M").hide();
       $("#cas1M").hide();
       $("#asap1M").hide();
       
       function myFunctioncdh() {
          var checkBox = document.getElementById("cdh");
          var text = document.getElementById("cdh1");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctionidu() {
          var checkBox = document.getElementById("idu");
          var text = document.getElementById("idu1");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctionsc() {
          var checkBox = document.getElementById("sc");
          var text = document.getElementById("sc1");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctioncas() {
          var checkBox = document.getElementById("cas");
          var text = document.getElementById("cas1");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctionasap() {
          var checkBox = document.getElementById("asap");
          var text = document.getElementById("asap1");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
        
         function myFunctioncdhM() {
          var checkBox = document.getElementById("cdhM");
          var text = document.getElementById("cdh1M");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctioniduM() {
          var checkBox = document.getElementById("iduM");
          var text = document.getElementById("idu1M");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctionscM() {
          var checkBox = document.getElementById("scM");
          var text = document.getElementById("sc1M");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctioncasM() {
          var checkBox = document.getElementById("casM");
          var text = document.getElementById("cas1M");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
         function myFunctionasapM() {
          var checkBox = document.getElementById("asapM");
          var text = document.getElementById("asap1M");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
      

   
    // $("#idu").click(function(){
    //     $("#idu1").show();
    
    // });
    
    // $("#sc").click(function(){
    //     $("#sc1").show();
    // });

    // $("#cas").click(function(){
    //     $("#cas1").show();
    
    // });
    
    // $("#asap").click(function(){
    //     $("#asap").show();
    // });


    

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
