<?php

namespace sportcontrol\Http\Controllers\Admin;

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
			if (Auth::attempt(['usuario' => $campos['usuario'], 'password' => $campos['senha'], 'ativo' => 'S','role' => 'admin'],$remember)) {				
				return redirect('/painel');
			}else{
				$erro = "Login ou Senha não existe";
				return view('admin.login')->with('erro',$erro);
			}
		}
	}
   public function sair(){
   		 Auth::logout();
   		 return redirect('/painel/login');
   }
    public function sairCostureira(){
   		 Auth::logout();
   		 return redirect('/painel/costureira/login');
   }
}
