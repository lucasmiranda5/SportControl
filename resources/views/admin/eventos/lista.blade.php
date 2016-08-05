@extends('template.admin')

@section('title', 'Eventos')
@section('conteudo')
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            eventos
            <small><a href="{{route('admin::eventos::novo')}}"class="btn btn-block btn-info btn-xs">Cadastrar</a></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">eventos</li>
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
                  <h3 class="box-title">Lista de Eventos</h3>
         
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Nome</th>
                        <th>Data Inicio</th>
                        <th>Data Final</th>
                        <th>Ações</th>                      
                      </tr>				
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nome</th>
                        <th>Data Inicio</th>
                        <th>Data Final</th>
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
                    "url": "{{route('admin::eventos::listar')}}",
                    "type": "GET"
                },
                "columns": [
                    { "data": "nome","name":"nome"},               
                    { "data": "data_inicio","name":"data_inicio"},               
                    { "data": "data_fim","name":"data_fim"},               
                    { "data": "acoes","name":"id" },                         
                ]
            } );
         
        } );    
    </script>  	  
@endsection