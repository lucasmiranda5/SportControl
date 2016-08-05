@extends('template.admin')
@section('title', 'Modalidades')
@section('conteudo')
<section class="content-header">
          <h1>
            Modalidade
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Modalidade</a></li>
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
						  <label for="campus">Modalidade</label>
						  @if($acao == 'novo')
						 <select name="modalidade" class="form-control">
						 	<option value="">-- Selecione uma opção --</option>
						 	@foreach($modalidades as $modalidade)
						 		<option value="{{$modalidade['id']}}">{{$modalidade['modalidade']}} - {{ (($modalidade['sexo'] == 'M' ? 'Masculino' : ($modalidade['sexo'] == 'F' ? 'Feminino' : "Misto")))}}</option>
						 	@endforeach
						 </select>
					   @else
					      <br><b>{{$modalidades['modalidade']}} - {{ (($modalidades['sexo'] == 'M' ? 'Masculino' : ($modalidades['sexo'] == 'F' ? 'Feminino' : "Misto"))) }}</b>
					    @endif
						</div>
						<div class="form-group">
						  <label for="campus">Data Limite para inscrição</label>
						  <input class="form-control data" id="data_limite" name="data_limite" value="{{(!empty($retorno['data_limite']) ? $retorno['data_limite'] : '')}}" placeholder="Data Limite para inscrição" type="text" >
						</div>
						<div class="form-group">
						  <label for="maximo">Numero maximo de atletas</label>
						  <input class="form-control" id="maximo" name="maximo" value="{{(!empty($retorno['maximo']) ? $retorno['maximo'] : '')}}" placeholder="Numero maximo de atletas" type="text" >
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