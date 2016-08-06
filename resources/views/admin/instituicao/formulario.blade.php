@extends('template.admin')
@section('title', 'Instituição')
@section('conteudo')
<section class="content-header">
          <h1>
            Instituição
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Instituição</a></li>
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
						  <input class="form-control" id="instituicao" name="instituicao" value="{{(!empty($retorno['instituicao']) ? $retorno['instituicao'] : '')}}" placeholder="Instituição" type="text" >
						</div>	
						<h3> Professor de educação física responsável</h3>
						<div class="form-group">
						  <label for="campus">Nome</label>
						  <input class="form-control" id="tecnico" name="tecnico" value="{{(!empty($retorno['tecnico']) ? $retorno['tecnico'] : '')}}" placeholder="Nome" type="text" >
						</div>
						<div class="form-group">
						  <label for="campus">SIAPE</label>
						  <input class="form-control" id="siape" name="siape" value="{{(!empty($retorno['siape']) ? $retorno['siape'] : '')}}" placeholder="SIAPE" type="text" >
						</div>
						<div class="form-group">
						  <label for="telefone">Telefone</label>
						  <input class="form-control" id="telefone" name="telefone" value="{{(!empty($retorno['telefone']) ? $retorno['telefone'] : '')}}" placeholder="Telefone" type="text" >
						</div>
						<div class="form-group">
						  <label for="campus">Email</label>
						  <input class="form-control" id="email" name="email" value="{{(!empty($retorno['email']) ? $retorno['email'] : '')}}" placeholder="Email" type="text" >
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