<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Usuarios;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;

class ControllerUsuario extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(Usuarios::query()->where('role','usuario')->orderBy('id', 'desc'))	
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::usuarios::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
				</div>';
	   		})->make(true);
	   	}else
			return view('admin.usuarios.lista');

			
	}
	public function editar($id){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$ob = Usuarios::where(function($query){
				$campos = Request::all();
				$query->where("email",$campos['email'])->orwhere("usuario",$campos['usuario']);
			})->where("id","<>",$id)->where('role','usuario')->count();
			if($ob > 0){
				$msg[0] = 'erro';
				$msg[1] = 'Já existe um outro usuario com o mesmo usuario e/ou email';
			}else{
				$objeto = Usuarios::find($id);
				$objeto->campus = $campos['campus'];
				$objeto->nome = $campos['nome'];
				$objeto->email = $campos['email'];
				$objeto->usuario = $campos['usuario'];
				$objeto->role = 'usuario';
				if($campos['senha'] != '')
					$objeto->password = bcrypt($campos['senha']);
				$objeto->ativo = 'S';
				$objeto->save();
				$msg[0] = 'sucesso';
				$msg[1] = 'Usuario editado com sucesso';
			}			
		}
		$retorno = Usuarios::find($id);
		$ob = Campus::find($retorno['campus']);
		$instituicoes = Instituicao::all();		
		$campus = Campus::where('instituicao',$ob['instituicao'])->get();
		$retorno['instituicao'] = $ob['instituicao'];
		return view('admin.usuarios.formulario')->with('acao','editar')->with('campus',$campus)->with('instituicoes',$instituicoes)->with('retorno',$retorno)->with('msg',$msg);
		
		
	}
	public function novo(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$ob = Usuarios::where(function($query){
				$campos = Request::all();
				$query->where("email",$campos['email'])->orwhere("usuario",$campos['usuario']);
			})->where('role','usuario')->count();
			if($ob > 0){
				$msg[0] = 'erro';
				$msg[1] = 'Já existe um outro usuario com o mesmo usuario e/ou email';
			}else{
				$objeto = new Usuarios;
				$objeto->campus = $campos['campus'];
				$objeto->nome = $campos['nome'];
				$objeto->email = $campos['email'];
				$objeto->usuario = $campos['usuario'];
				$objeto->role = 'usuario';
				$objeto->password = bcrypt($campos['senha']);
				$objeto->ativo = 'S';
				$objeto->save();
				$msg[0] = 'sucesso';
				$msg[1] = 'Usuario cadastrado com sucesso';
			}			
		}
		$instituicoes = Instituicao::all();
		return view('admin.usuarios.formulario')->with('acao','novo')->with('instituicoes',$instituicoes)->with('msg',$msg);		
	}	
	function campus($id){
		return Campus::where('instituicao',$id)->get();
	}
	
}
