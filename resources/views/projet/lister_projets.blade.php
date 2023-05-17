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
   <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
    
    <div class="content-form">
   <h2>Les projets</h2>
 <h6> 
              @if (session('message'))
                  <div class="alert alert-success" style="background-color:lightgreen" role="alert">
                      {{ session('message') }}
                  </div>  
              @endif
            </h6>
<table>
  <tr>
    <th>Nom de l'organisation</th>
    <th>Statut</th>
    <th>Type</th>
    <th>Région</th>
    <th>Département</th>
    <th>Options</th>
  </tr>
  @foreach($projets as $projet)
  <tr>
    <td>{{$projet->libelle}}</td>
    <td>{{$projet->statut}}</td>
    <td>{{$projet->type}}</td>
    <td>{{$projet->region}}</td>
    <td>{{$projet->departement}}</td>
    <td><a href="{{route('editer_projet_1', $projet->id)}}">Modifier</a>
    <a href="{{route('details_projet', $projet->id)}}">Show</a>
    <form action="{{ route('delete_projet',$projet->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm ('Voulez-vous vraiment supprimer le projet?')" data-toggle="tooltip" data-placement="top" title="Supprimer la vidéo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-x-fill" viewBox="0 0 16 16">
                          <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM6.854 6.146 8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 1 1 .708-.708z"/>
                        </svg>
                        
                        </button>
                </form>
    </td>
  </tr>
 @endforeach
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
