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
    <form action="{{route('store_projet_4', $projet->id)}}" method="post" class="form-horizontal" id="demo1-upload" enctype="multipart/form-data">
                                    {{ csrf_field() }}
            

           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           <input type="hidden" name="token" id="token" value="{{ Illuminate\Support\Str::random(155) }}" aria-describedby="name" placeholder="">

            <div class="form-one Setp">
               <div class="head-form">
                   <h2>Etape 4 ajouter un projet</h2>
                   
               </div>
                <div class="step1e">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-element-2">

                                 <p class="text-description">3.1 Secteur d'intervention et investissement financier</p>
                                       
                                    <p class="text-description">Plusieurs réponses possibles</p>
                                   
                                
                                <div class="form-group display-grid">
                                    <label for="exampleFormControlSelect2" style="color:black;">Cliquer sur le cadre pour Sélectionner les secteur d'intervention et investissement financier<span style="color:red;">*</span>  </label>
                                    <select name="secteur_id[]" class="form-control" multiple data-allow-clear="1" required>
                                    <option value="">Sélectionner</option>
                                        @foreach($secteurs as $secteur)
                                        <option value="{{$secteur->id}}">{{$secteur->libelle}}</option>
                                        @endforeach
                                        <!--<option value="" id="check_autre">Autres</option>-->
                                    </select>
                                </div>
                                
                                <div class="form-group" id="autre">
                                    <label for="name" style="color:black;">Autres secteur intervention</label>
                                    <input type="text" class="form-control" id="name" name="autre_intervention" aria-describedby="name" placeholder="">
                                   </div>
                                   
                                <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="autre_inter" onclick="myFunctionautreinter()" >
                                            <label class="label-radio" for="image" style="color:black;">Autre</label>
                                        </div>
                               
                              <p class="text-description">3.2 Nombre de projets implémentés</p> 
                                <div class="form-group" style="color:black;">

                                    <div class="group-select-challanges">
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="cdh" onclick="myFunctioncdh()" >
                                            <label class="label-radio" for="image" style="color:black;">CDH</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="cdh1">
                                            <label for="name" style="color:black;">Donner le nombre : </label>
                                            <input type="hidden" class="single" name="libelle[]" value="CDH">
                                            <input type="number" class="single"  name="nombre[]">
                                        </div>
                                        
                                         <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="idu" onclick="myFunctionidu()">
                                            <label class="label-radio" for="image" style="color:black;">IDU</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="idu1">
                                            <label for="name" style="color:black;">Donner le nombre : </label>
                                            <input type="hidden" class="single"  name="libelle[]" value="IDU">
                                            <input type="number" class="single"  name="nombre[]">
                                        </div>
                                        
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="sc"  onclick="myFunctionsc()">
                                            <label class="label-radio" for="image" style="color:black;">SC</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="sc1">
                                            <label for="name" style="color:black;">Donner le nombre : </label>
                                            <input type="hidden" class="single"  name="libelle[]" value="SC">
                                            <input type="number" class="single"  name="nombre[]">
                                        </div>
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="cas" onclick="myFunctioncas()" >
                                            <label class="label-radio" for="image" style="color:black;">CAS</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="cas1">
                                            <label for="name" style="color:black;">Donner le nombre : </label>
                                            <input type="hidden" class="single"  name="libelle[]" value="CAS">
                                            <input type="number" class="single"  name="nombre[]">
                                        </div>
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="asap" onclick="myFunctionasap()" >
                                            <label class="label-radio" for="image" style="color:black;">ASAP</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="asap1">
                                            <label for="name" style="color:black;">Donner le nombre : </label>
                                            <input type="hidden" class="single"  name="libelle[]" value="ASAP">
                                            <input type="number" class="single"  name="nombre[]">
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                <p class="text-description">3.3 Montant en FCFA par secteur investissement directe (saisir le montant en chiffres en FCFA)</p> 
                                <div class="form-group" style="color:black;">

                                    <div class="group-select-challanges">
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="cdhM" onclick="myFunctioncdhM()">
                                            <label class="label-radio" for="image" style="color:black;">CDH</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="cdh1M">
                                            <label for="name" style="color:black;">Donner le montant : </label>
                                            <input type="hidden" class="single" name="libelleM[]" value="CDH">
                                            <input type="number" class="single"  name="montant[]">
                                        </div>
                                        
                                         <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="iduM" onclick="myFunctioniduM()" >
                                            <label class="label-radio" for="image" style="color:black;">IDU</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="idu1M">
                                            <label for="name" style="color:black;">Donner le montant : </label>
                                            <input type="hidden" class="single"  name="libelleM[]" value="IDU">
                                            <input type="number" class="single"  name="montant[]">
                                        </div>
                                        
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="scM"  onclick="myFunctionscM()">
                                            <label class="label-radio" for="image" style="color:black;">SC</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="sc1M">
                                            <label for="name" style="color:black;">Donner le montant : </label>
                                            <input type="hidden" class="single"  name="libelleM[]" value="SC">
                                            <input type="number" class="single"  name="montant[]">
                                        </div>
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="casM" onclick="myFunctioncasM()">
                                            <label class="label-radio" for="image" style="color:black;">CAS</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="cas1M">
                                            <label for="name" style="color:black;">Donner le montant : </label>
                                            <input type="hidden" class="single"  name="libelleM[]" value="CAS">
                                            <input type="number" class="single"  name="montant[]">
                                        </div>
                                        
                                        <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="asapM" onclick="myFunctionasapM()">
                                            <label class="label-radio" for="image" style="color:black;">ASAP</label>
                                        </div>
                                        
                                        <div class="form-group-radio" id="asap1M">
                                            <label for="name" style="color:black;">Donner le montant : </label>
                                            <input type="hidden" class="single"  name="libelleM[]" value="ASAP">
                                            <input type="number" class="single"  name="montant[]">
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group" id="autre_montant1">
                                    <label for="name" style="color:black;">Autres montant</label>
                                    <input type="text" class="form-control" id="name" name="autre_montant" aria-describedby="name" placeholder="">
                                   </div>
                                   
                                <div class="form-group-radio">
                                            <input type="checkbox" class="single" id="autre_montan" onclick="myFunctionautremontant()" >
                                            <label class="label-radio" for="image" style="color:black;">Autre</label>
                                        </div>
                                
                  
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
       $("#autre").hide();
       
        $("#autre_montant1").hide();
       
        function myFunctionautremontant() {
          var checkBox = document.getElementById("autre_montan");
          var text = document.getElementById("autre_montant1");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        
        function myFunctionautreinter() {
          var checkBox = document.getElementById("autre_inter");
          var text = document.getElementById("autre");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
       
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
