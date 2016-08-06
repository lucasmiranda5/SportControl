<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;

class ControllerInstituicao extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(Instituicao::query()->orderBy('id', 'desc'))			
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::instituicao::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
				</div>';
	   		})->make(true);
	   	}else
			return view('admin.instituicao.lista');

			
	}
	public function editar($id){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$objeto = Instituicao::find($id);
			$objeto->instituicao = $campos['instituicao'];
			$objeto->tecnico = $campos['tecnico'];
			$objeto->siape = $campos['siape'];
			$objeto->email = $campos['email'];
			$objeto->telefone = $campos['telefone'];
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Instituição adicionada com sucesso';
			
		}
		$retorno = Instituicao::find($id);
			return view('admin.instituicao.formulario')->with('acao','editar')->with('retorno',$retorno)->with('msg',$msg);
		
		
	}
	public function novo(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$objeto =  new Instituicao;
			$objeto->instituicao = $campos['instituicao'];
			$objeto->tecnico = $campos['tecnico'];
			$objeto->siape = $campos['siape'];
			$objeto->email = $campos['email'];
			$objeto->telefone = $campos['telefone'];
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Instituição adicionada com sucesso';
		}
		return view('admin.instituicao.formulario')->with('acao','novo')->with('msg',$msg);		
	}	
	
	
}
