@extends('template.admin')
@section('title', 'Categoria de modalidades')
@section('conteudo')
<section class="content-header">
          <h1>
            Categoria de modalidades
            <small>{{$acao}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Categoria de modalidades</a></li>
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
						  <label for="nome">Nome</label>
						  <input class="form-control" id="nome" name="nome" value="{{(!empty($retorno['nome']) ? $retorno['nome'] : '')}}" placeholder="Nome" type="text" >
						</div>	
					 	<div class="form-group">
						  <label for="possui_sub">Possui sub esporte ?</label>
						  <select name="possui_sub" required class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		<option {{((!empty($retorno['possui_sub']) and $retorno['possui_sub'] == 'S') ? 'selected' : '')}} value="S">Sim</option>
						  		<option {{((!empty($retorno['possui_sub']) and $retorno['possui_sub'] == 'N') ? 'selected' : '')}} value="N">Não</option>
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
		
	
@endsection