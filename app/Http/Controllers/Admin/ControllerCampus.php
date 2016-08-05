<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;

class ControllerCampus extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(Campus::query()->orderBy('id', 'desc'))
			->editColumn('instituicao',function($model){
				$ins = Instituicao::find($model->instituicao);
				return $ins['instituicao'];
			})			
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::campus::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
				</div>';
	   		})->make(true);
	   	}else
			return view('admin.campus.lista');

			
	}
	public function editar($id){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$objeto = Campus::find($id);
			$objeto->campus = $campos['campus'];
			$objeto->instituicao = $campos['instituicao'];
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Campus adicionada com sucesso';
			
		}
		$retorno = Campus::find($id);
			return view('admin.campus.formulario')->with('acao','editar')->with('instituicoes',$instituicoes)->with('retorno',$retorno)->with('msg',$msg);
		
		
	}
	public function novo(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$objeto =  new Campus;
			$objeto->campus = $campos['campus'];
			$objeto->instituicao = $campos['instituicao'];
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Campus adicionada com sucesso';
		}
		$instituicoes = Instituicao::all();
		return view('admin.campus.formulario')->with('acao','novo')->with('instituicoes',$instituicoes)->with('msg',$msg);		
	}	
	
	
}
