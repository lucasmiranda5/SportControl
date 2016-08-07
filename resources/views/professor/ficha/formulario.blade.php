@extends('template.professor')
@section('title', 'Ficha de inscrição')
@section('conteudo')
<section class="content-header">
          <h1>
            Ficha de inscrição
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Fichas de inscrição</a></li>
          </ol>
        </section>
		<section class="content">
			<form action="" enctype="multipart/form-data" method="post" class="form" role="form">	
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
					<div class="box box-primary">
					
					<!-- form start -->
					
					  <div class="box-body">
					  <div class="form-group">
						  <label for="instituicao">Evento</label>
						  <select name="evento" required class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		@foreach($eventos as $evento)
						  			<option value="{{$evento['id']}}">{{$evento['nome']}}</option>
						  		@endforeach
						  </select>
						</div>
					 			
						<div class="div"></div>
						
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
			
			$('.form').submit(function(){
				$('.div').html("<h2>Aguarde! Gerando a ficha</h2>");
				$.post('{{ route("professor::fichas::gerar") }}',$('.form').serialize(), function(data) {
						$('.div').html(data);
					});
				return false;
			})
			
			
		})
	</script>
@endsection