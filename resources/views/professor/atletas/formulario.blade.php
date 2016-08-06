@extends('template.professor')
@section('title', 'Atletas')
@section('conteudo')
<section class="content-header">
          <h1>
            Atletas
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Atletas</a></li>
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
							<label>Nome</label>
							<input type="text" required name="nome" class="form-control" value="{{(!empty($retorno['nome']) ? $retorno['nome'] : '') }}">
						</div>
						<div class="form-group">
							<label>Data de nascimento</label>
							<input type="text" required  name="data_nascimento" class="data form-control" value="{{(!empty($retorno['data_nascimento']) ? $retorno['data_nascimento'] : '') }}">
						</div>
						<div class="form-group">
						  <label for="sexo">Sexo</label>
						  <select name="sexo" required class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		<option {{((!empty($retorno['sexo']) and $retorno['sexo'] == 'M') ? 'selected' : '')}} value="M">Masculino</option>
						  		<option {{((!empty($retorno['sexo']) and $retorno['sexo'] == 'F') ? 'selected' : '')}} value="F">Feminino</option>
						  	
						  </select>
						</div>	
						<div class="form-group">
							<label>Matricula</label>
							<input type="text" name="matricula" class="form-control" value="{{(!empty($retorno['matricula']) ? $retorno['matricula'] : '') }}">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" class="form-control" value="{{(!empty($retorno['email']) ? $retorno['email'] : '') }}">
						</div>
						<div class="form-group">
							<label>CPF</label>
							<input type="text" name="cpf" class="cpf form-control" value="{{(!empty($retorno['cpf']) ? $retorno['cpf'] : '') }}">
						</div>
						<div class="form-group">
							<label>Telefone</label>
							<input type="text" name="telefone" class="form-control" value="{{(!empty($retorno['telefone']) ? $retorno['telefone'] : '') }}">
						</div>
						<div class="form-group">
							<label>RG</label>
							<input type="text" name="rg" class="form-control" value="{{(!empty($retorno['rg']) ? $retorno['rg'] : '') }}">
						</div>
					  </div><!-- /.box-body -->
					  <div class="form-group">
		                  <label for="exampleInputFile">Foto</label>
		                  <input id="foto" type="file" name="imagem">
		               </div>
		               @if($acao == 'editar')
		               	@if($retorno['foto'] != '')
		               	  <img src="<?=App::make('url')->to('/');?>/images/{{ $retorno['foto'] }}" width="300px">
		               	@endif
		               @endif
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
			$('.cpf').mask('999.999.999-99');
			
		})
	</script>
@endsection