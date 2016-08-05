@extends('template.admin')
@section('title', 'Campus')
@section('conteudo')
<section class="content-header">
          <h1>
            Campus
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Campus</a></li>
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
						  <select name="instituicao" class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		@foreach($instituicoes as $instituicao)
						  			<option {{ ((!empty($retorno['instituicao']) and $retorno['instituicao'] = $instituicao['id']) ? 'selected' : '') }} value="{{$instituicao['id']}}">{{$instituicao['instituicao']}}</option>
						  		@endforeach
						  </select>
						</div>	
						<div class="form-group">
						  <label for="campus">Campus</label>
						  <input class="form-control" id="campus" name="campus" value="{{(!empty($retorno['campus']) ? $retorno['campus'] : '')}}" placeholder="Campus" type="text" >
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
		
	
@endsection