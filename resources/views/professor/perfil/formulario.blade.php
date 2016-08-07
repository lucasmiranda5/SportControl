@extends('template.professor')
@section('title', 'Perfil')
@section('conteudo')
<section class="content-header">
          <h1>
            Perfil
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Perfil</a></li>
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
						  <label for="instituicao">Instituição</label><br>
						 {{ $retorno['instituicao']}}
						</div>	
						<div class="form-group">
						  <label for="instituicao">Campus</label><br>
						  {{ $retorno['campus']}}
						  
						</div>	
						<div class="form-group">
							<label>Nome</label>
							<input type="text" required name="nome" class="form-control" value="{{(!empty($retorno['nome']) ? $retorno['nome'] : '') }}">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" required  name="email" class="form-control" value="{{(!empty($retorno['email']) ? $retorno['email'] : '') }}">
						</div>
						<div class="form-group">
							<label>Usuario</label>
							<input type="text" required name="usuario" class="form-control" value="{{(!empty($retorno['usuario']) ? $retorno['usuario'] : '') }}">
						</div>
						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="senha" class="form-control" value="">
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