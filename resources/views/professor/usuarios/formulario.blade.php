@extends('template.admin')
@section('title', 'Usuarios')
@section('conteudo')
<section class="content-header">
          <h1>
            Usuarios
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Usuarios</a></li>
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
						  <label for="instituicao">Instituição</label>
						  <select name="instituicao" required class="form-control instituicao">
						  		<option value="">-- Selecione uma opção --</option>
						  		@foreach($instituicoes as $instituicao)
						  			<option {{ ((!empty($retorno['instituicao']) and $retorno['instituicao'] = $instituicao['id']) ? 'selected' : '') }} value="{{$instituicao['id']}}">{{$instituicao['instituicao']}}</option>
						  		@endforeach
						  </select>
						</div>	
						<div class="form-group">
						  <label for="instituicao">Campus</label>
						  <select name="campus" required class="form-control campus">
						  		@if($acao == 'novo')
						  			<option value="">-- Selecione a instituicao primeiro --</option>
						  		@elseif($acao == 'editar')
						  		@foreach($campus as $campu)
						  			<option {{ ((!empty($retorno['campus']) and $retorno['campus'] == $campu['id']) ? 'selected' : '') }} value="{{$campu['id']}}">{{$campu['campus']}}</option>
						  		@endforeach
						  		@endif
						  </select>
						</div>	
						<div class="form-group">
							<label>Nome</label>
							<input type="text" required name="nome" class="form-control" value="{{(!empty($retorno['nome']) ? $retorno['nome'] : '') }}">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" required  name="email" class="form-control" value="{{(!empty($retorno['nome']) ? $retorno['nome'] : '') }}">
						</div>
						<div class="form-group">
							<label>Usuario</label>
							<input type="text" required name="usuario" class="form-control" value="{{(!empty($retorno['nome']) ? $retorno['nome'] : '') }}">
						</div>
						<div class="form-group">
							<label>Senha</label>
							<input type="password" {{ ($acao=='novo' ? 'required' : '')}} name="senha" class="form-control" value="">
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
			$('.instituicao').change(function(){
				if($(this).val() != ''){
					html = "<option value=''>--Selecione um campus--</option>";
					$.get('{{ route("admin::usuarios::campus") }}/'+$(this).val(), function(data) {
						for(d in data){
							html = html + "<option value='"+data[d].id+"'>"+data[d].campus+"</option>";
						}
						$('.campus').html(html);
					});

				}else{
					$('.campus').html("<option value=''>--- Selecione uma instituicao --</option>");
				}
			})
		})
	</script>
@endsection