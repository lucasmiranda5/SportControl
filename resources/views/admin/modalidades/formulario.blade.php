@extends('template.admin')
@section('title', 'Modalidades')
@section('conteudo')
<section class="content-header">
          <h1>
            Modalidades
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Modalidades</a></li>
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
						  <input class="form-control" id="nome" name="nome" value="{{(!empty($retorno['modalidade']) ? $retorno['modalidade'] : '')}}" placeholder="Nome" type="text" >
						</div>
						<div class="form-group">
						  <label for="sexo">Sexo</label>
						  <select name="sexo" required class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		<option {{((!empty($retorno['sexo']) and $retorno['sexo'] == 'M') ? 'selected' : '')}} value="M">Masculino</option>
						  		<option {{((!empty($retorno['sexo']) and $retorno['sexo'] == 'F') ? 'selected' : '')}} value="F">Feminino</option>
						  		<option {{((!empty($retorno['sexo']) and $retorno['sexo'] == 'MI') ? 'selected' : '')}} value="MI">Misto</option>
						  </select>
						</div>	
					 	<div class="form-group">
						  <label for="instituicao">Categoria</label>
						  <select name="categoria" class="form-control categoria">
						  		<option value="">-- Selecione uma opção --</option>
						  		@foreach($categorias as $categoria)
						  			<option data-sub="{{$categoria['possui_sub']}}" {{ ((!empty($retorno['categoria']) and $retorno['categoria'] == $categoria['id']) ? 'selected' : '') }} value="{{$categoria['id']}}">{{$categoria['nome']}}</option>
						  		@endforeach
						  </select>
						</div>	

						<div class="form-group possuisub" {{ ((empty($retorno['sub'])) ? 'style=display:none' : '') }} >
						  <label for="instituicao">Sub Modalidade</label>
						  <select name="instituicao" class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		@foreach($modalidades as $modalidade)
						  			<option {{ ((!empty($retorno['sub']) and $retorno['sub'] == $modalidade['id']) ? 'selected' : '') }} value="{{$modalidade['id']}}">{{$modalidade['modalidade']}}</option>
						  		@endforeach
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
			$('.categoria').change(function() {
				var sub = $(".categoria :selected").attr('data-sub');
				if(sub == 'S'){
					$('.possuisub').css("display",'');
				}else{
					$('.possuisub').css("display",'none');
				}
			});
		})
		</script>
	
@endsection