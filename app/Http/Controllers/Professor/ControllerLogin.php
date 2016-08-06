<?php

namespace sportcontrol\Http\Controllers\Professor;

use sportcontrol\Http\Requests;
use sportcontrol\Usuarios;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class ControllerLogin extends Controller
{
	public function login(){
		$campos = Request::all();
		if($campos['usuario'] != '' and $campos['senha'] != ''){
			$remember = (empty($campos['lembrar']) ? false : true);
			if (Auth::attempt(['usuario' => $campos['usuario'], 'password' => $campos['senha'], 'ativo' => 'S','role' => 'usuario'],$remember)) {				
				return redirect('/'); 
			}else{
				$erro = "Login ou Senha não existe";
				return view('professor.login')->with('erro',$erro);
			}
		}
	}
   public function sair(){
   		 Auth::logout();
   		 return redirect('/login');
   }

}
