@extends('template.admin')
@section('title', 'Eventos')
@section('conteudo')
<section class="content-header">
          <h1>
            Eventos
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Eventos</a></li>
            <li class="active"><?=$acao?></li>
          </ol>
        </section>
		<section class="content">
			<form action="" enctype="multipart/form-data" method="post" role="form">	
			<input type="hidden" name="acao" value="{{$acao}}">
			<div class="row">
			
			@if(!empty($msg) and $msg[0] == 'erro')
				<div class="callout callout-danger">
					<h4>Erro!</h4>
                    <p>{{$msg[1]}}</p>
                 </div>
			@endif
			@if(!empty($msg) and $msg[0] == 'sucesso')
				<div class="callout callout-success">
					<h4>Sucesso!</h4>
					<p>{{$msg[1]}}</p>
				</div>
			@endif
				<div class="col-md-12">
					 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					 <input type="hidden" name="acao" value="{{{ $acao }}}" />
					<div class="box box-primary">					
					<!-- form start -->					
					  <div class="box-body">
					  	<div class="form-group">
						  <label for="campus">Nome</label>
						  <input class="form-control" id="nome" name="nome" value="{{(!empty($retorno['nome']) ? $retorno['nome'] : '')}}" placeholder="Nome" type="text" >
						</div>
						<div class="form-group">
						  <label for="campus">Data de inicio</label>
						  <input class="form-control data" id="data_inicio" name="data_inicio" value="{{(!empty($retorno['data_inicio']) ? $retorno['data_inicio'] : '')}}" placeholder="Data de inicio" type="text" >
						</div>
						<div class="form-group">
						  <label for="campus">Data de termino</label>
						  <input class="form-control data" id="data_fim" name="data_fim" value="{{(!empty($retorno['data_fim']) ? $retorno['data_fim'] : '')}}" placeholder="Data de termino" type="text" >
						</div>
						<div class="form-group">
						  <label for="site">Site</label>
						  <input class="form-control" id="site" name="site" value="{{(!empty($retorno['site']) ? $retorno['site'] : '')}}" placeholder="Site" type="text" >
						</div>
						<div class="form-group">
						  <label for="por">Disputado por:</label>
						  <select name="por" required class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		<option {{((!empty($retorno['por']) and $retorno['por'] == 'I') ? 'selected' : '')}} value="I">Instituição</option>
						  		<option {{((!empty($retorno['por']) and $retorno['por'] == 'C') ? 'selected' : '')}} value="C">Campus</option>						  		
						  </select>
						</div>								
					  </div><!-- /.box-body -->
					   <div class="box-footer">
						<button type="submit" class="btn btn-primary">Enviar</button>
					  </div>
				  </div>
				</div>
			</div>
			</div>			
			</form>
		</section>
		<script>
		$(function(){
			$('.data').mask("99/99/9999");

		})
		</script>
	
@endsection