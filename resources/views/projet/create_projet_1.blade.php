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
    <form action="{{route('store_projet_1')}}" method="post" class="form-horizontal" id="demo1-upload" enctype="multipart/form-data">
                                    {{ csrf_field() }}
            

           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           <input type="hidden" name="token" id="token" value="{{ Illuminate\Support\Str::random(155) }}" aria-describedby="name" placeholder="">

            <div class="form-one Setp">
               <div class="head-form">
                   <h2>Etape 1 ajouter un projet</h2>
                   
               </div>
                <div class="step1e">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-element-2">
                            <!-- <p class="title">Formation : </p>-->
                            <p class="text-description">1. Identification </p>
        
                                  
                                <div class="form-group">
                                    <label for="name" style="color:black;">1.1 Nom de l'organisation<span style="color:red">*</span> : </label>
                                    <input required type="text" class="form-control" id="name" name="libelle" aria-describedby="name" placeholder="">
                                </div>
                               
                                <!--<div class="form-group" style="color:black;">-->
                                <!--    <label for="exampleFormControlTextarea1" style="color:black;">1.2 Statut<span style="color:red">*</span></label>-->
                                    
                                <!--    <div class="group-select-challanges">-->
                                <!--        <div class="form-group-radio">-->
                                <!--            <input type="radio" id="image" class="single-checkbox1"  name="statut" value="0" checked>-->
                                <!--            <label class="label-radio" for="image" style="color:black;">statut</label>-->
                                <!--        </div>-->
                                <!--        <div class="form-group-radio">-->
                                <!--            <input type="radio" id="video" class="single-checkbox1"  name="statut" value="1">-->
                                <!--            <label class="label-radio" for="video" style="color:black;">ONG</label>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                
                                  <div class="form-group">
                                      <label for="exampleFormControlTextarea1" style="color:black;">1.2 Statut<span style="color:red">*</span></label>
                                        <select name="statut" class="form-controll">
                                             <option value="" disabled>Sélectionner le statut</option>
                                            <option value="0">Association</option>
                                            <option value="1">ONG</option>
                                           
                                        </select>
                                        </div>
                            
                                 <div class="form-group">
                                     <label for="exampleFormControlTextarea1" style="color:black;">1.3 type</label>
                                        <select name="type" class="form-controll">
                                             <option value="" disabled>Sélectionner le type</option>
                                            <option value="0">National</option>
                                            <option value="1">International</option>
                                           
                                        </select>
                                        </div>
                                <p class="text-description">1.3 Zone d'intervention </p>
                              <div class="form-group">
                                    <label for="name" style="color:black;">1.3.1 Région<span style="color:red">*</span> : </label>
                                    <input required type="text" class="form-control" id="name" name="region" aria-describedby="name" placeholder="">
                                </div>
                                
                                 <div class="form-group">
                                    <label for="name" style="color:black;">1.3.2 Département<span style="color:red">*</span> : </label>
                                    <input required type="text" class="form-control" id="name" name="departement" aria-describedby="name" placeholder="">
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
