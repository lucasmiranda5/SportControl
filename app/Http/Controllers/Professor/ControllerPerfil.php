<?php

namespace sportcontrol\Http\Controllers\Professor;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Usuarios;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;
use Auth;

class ControllerPerfil extends Controller
{
	public function __construct(){
		  $this->middleware('auth.user');
	}
	public function editar(){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$ob = Usuarios::where(function($query){
				$campos = Request::all();
				$query->where("email",$campos['email'])->orwhere("usuario",$campos['usuario']);
			})->where("id","<>",Auth::user()->id)->where('role','usuario')->count();
			if($ob > 0){
				$msg[0] = 'erro';
				$msg[1] = 'Já existe um outro usuario com o mesmo usuario e/ou email';
			}else{
				$objeto = Usuarios::find(Auth::user()->id);
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
		$retorno = Usuarios::find(Auth::user()->id);
		$campus = Campus::find(Auth::user()->campus);
		$inst = Instituicao::find($campus['instituicao']);
		$retorno['instituicao'] = $inst['instituicao'];
		$retorno['campus'] = $campus['campus'];
		return view('professor.perfil.formulario')->with('acao','editar')->with('retorno',$retorno)->with('msg',$msg);
		
		
	}
	
	
	
}
