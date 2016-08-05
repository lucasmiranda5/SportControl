@extends('template.admin')

@section('title', 'Eventos')
@section('conteudo')
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Modalidades do {{ $evento['nome']}}
            <small><a href="{{route('admin::eventos::modalidades::novo',$evento['id'])}}"class="btn btn-block btn-info btn-xs">Cadastrar</a></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Modalidades do {{ $evento['nome']}}</li>
          </ol>
        </section>
		<section class="content">
		<div class="row">
		@if(!empty($msg) and [0] == 'erro'):
				<div class="callout callout-danger">
					<h4>Erro!</h4>
                    <p>{{$msg[1]}}</p>
                 </div>
			@endif
			@if(!empty($msg) and $msg[0] == 'sucesso'):
				<div class="callout callout-success">
					<h4>Sucesso!</h4>
					<p>{{$msg[1]}}</p>
				</div>
			@endif
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista de modalidades do {{ $evento['nome']}}</h3>
         
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Modalidade</th>
                        <th>Nº Maximo de atletas</th>
                        <th>Data limite para inscrição</th>
                        <th>Ações</th>                      
                      </tr>				
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Modalidade</th>
                        <th>Nº Maximo de atletas</th>
                        <th>Data limite para inscrição</th>
                        <th>Ações</th>                      
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
            var table = $('.table').DataTable( {
              "language":{
                "url": "<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables/Portuguese-Brasil.json"
              },
                "procura": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{route('admin::eventos::modalidades::listar',$evento['id'])}}",
                    "type": "GET"
                },
                "columns": [
                    { "data": "modalidade","name":"modalidade"},               
                    { "data": "maximo","name":"maximo"},               
                    { "data": "data_limite","name":"data_limite"},               
                    { "data": "acoes","name":"id" },                         
                ]
            } );
         
        } );    
    </script>  	  
@endsection