@extends('template.admin')
@section('title', 'Equipes')
@section('conteudo')
<section class="content-header">
          <h1>
            Equipe
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">equipe</a></li>
          </ol>
        </section>
		<section class="content">
			<form action="" enctype="multipart/form-data" method="post" class="form" role="form">	
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
						  <label for="instituicao">Evento</label>
						  <select name="evento" required class="form-control">
						  		<option value="">-- Selecione uma opção --</option>
						  		@foreach($eventos as $evento)
						  			<option value="{{$evento['id']}}">{{$evento['nome']}}</option>
						  		@endforeach
						  </select>
						</div>
					 	<div class="form-group">
						  <label for="instituicao">Instituição</label>
						  <select name="instituicao" required class="form-control instituicao">
						  		<option value="">-- Selecione uma opção --</option>
						  		@foreach($instituicoes as $instituicao)
						  			<option value="{{$instituicao['id']}}">{{$instituicao['instituicao']}}</option>
						  		@endforeach
						  </select>
						</div>	
						<div class="form-group">
						  <label for="instituicao">Campus</label>
						  <select name="campus" required class="form-control campus">
						  			<option value="">-- Selecione a instituicao primeiro --</option>	
						  </select>
						</div>	
						<div class="form-group">
						  <label for="instituicao">Modalidade</label>
						  <select name="modalidade" required class="form-control modalidade">
						  			<option value="">-- Selecione o campus primeiro --</option>	
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
			});
			$('.campus').change(function(){
				if($(this).val() != ''){
					html = "<option value=''>--Selecione uma modalidade--</option>";
					$.post('{{ route("admin::equipes::modalidades") }}',$('.form').serialize(), function(data) {
						for(d in data){
							html = html + "<option value='"+data[d].id+"'>"+data[d].nome+"</option>";
						}
						$('.modalidade').html(html);
					});

				}else{
					$('.modalidade').html("<option value=''>--- Selecione um campus --</option>");
				}
			});
			$('.modalidade').change(function(){
				if($(this).val() != ''){
					$.post('{{ route("admin::equipes::chamarAtletas") }}',$('.form').serialize(), function(data) {
						
						$('.div').html(data);
					});

				}
			})
		})
	</script>
@endsection