@extends('template.professor')

@section('title', 'Modalidades')
@section('conteudo')
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Modalidades
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Atletas</li>
          </ol>
        </section>
		<section class="content">
		<div class="row">
		
            <div class="col-xs-12">
              <div class="box">
              <div class="form-group">
                <label>Escolha o evento</label>
                <select class="evento form-control">
                  <option value="">-- Selecione um evento --</option>
                  @foreach($eventos as $evento)
                    <option value="{{ $evento['id'] }}">{{$evento['nome']}}</option>
                  @endforeach
                </select> 
                <div class="box-header">
                  <h3 class="box-title">Lista de Modalidades</h3>
         
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Modalidades</th>
                        <th>Sexo</th>
                        <th>Numero maximo de atletas</th>
                      </tr>				
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Modalidades</th>
                        <th>Sexo</th>
                        <th>Numero maximo de atletas</th>
                      </tr>       
                    </tfoot>	
					         </table>
                
                </div><!-- /.box-body -->
				<div class="box-footer clearfix">
                </div>
              </div><!-- /.box -->
            </div>
          </div>
		  </section>	
      <script>
      $(document).ready(function() {
            $('.evento').change(function(){
              if($(this).val() != ''){
                var table = $('.table').DataTable( {
                  "language":{
                    "url": "<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables/Portuguese-Brasil.json"
                  },
                    "procura": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{route('professor::modalidade::listar')}}/"+$(this).val(),
                        "type": "GET"
                    },
                    "columns": [
                        { "data": "modalidade","name":"modalidade"},               
                        { "data": "campus","name":"campus"},               
                        { "data": "maximo","name":"id"},               
                    ]
                } );
              }
            })
         
        } );    
    </script>  	  
@endsection