<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Usuarios;
use sportcontrol\Atletas;
use sportcontrol\Funcoes;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;
use Carbon\Carbon;

class ControllerAtletas extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(Atletas::query()->orderBy('id', 'desc'))
			->editColumn('campus',function($model){
				$ins = Campus::find($model->campus);
				return $ins['campus'];
			})		
			->editColumn('instituicao',function($model){
				$ins = Instituicao::find($model->instituicao);
				return $ins['instituicao'];
			})		
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::atletas::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
				</div>';
	   		})->make(true);
	   	}else
			return view('admin.atletas.lista');

			
	}
	public function editar($id){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$ob = 0;
			$ob2 = 0;
			$ob3 = 0;
			if($campos['rg'] != '')
				$ob = Atletas::where("rg",$campos['rg'])->where('campus',$campos['campus'])->where("id","<>",$id)->count();
			if($campos['matricula'] != '')
				$ob2 = Atletas::where("matricula",$campos['matricula'])->where('campus',$campos['campus'])->where("id","<>",$id)->count();
			if($campos['cpf'] != '')
				$ob3 = Atletas::where("cpf",$campos['cpf'])->where('campus',$campos['campus'])->where("id","<>",$id)->count();			
			if($ob > 0 or $ob2 > 0 or $ob3 > 0){
				$msg[0] = 'erro';
				$msg[1] = 'Já existe um outro usuario com o mesmo usuario e/ou email';
			}else{
				$objeto = Atletas::find($id);
				$objeto->nome = $campos['nome'];
				$objeto->data_nascimento = Funcoes::data($campos['data_nascimento'],'db');
				$objeto->campus = $campos['campus'];
				$objeto->sexo = $campos['sexo'];
				$objeto->instituicao = $campos['instituicao'];
				$objeto->matricula = $campos['matricula'];
				$objeto->email = $campos['email'];
				$objeto->telefone = $campos['telefone'];
				$objeto->rg = $campos['rg'];
				$objeto->cpf = $campos['cpf'];
				if(isset($campos['imagem'])) {
					$file = $campos['imagem'];
					$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());            
					$name = $timestamp. '-' .$file->getClientOriginalName();
					if($objeto['foto'] != '')
						@unlink(base_path().'/images/'.$objeto['foto']);
					$objeto['foto'] = $name;
					$file->move(base_path().'/images/', $name);
				}
				$objeto->save();
				$msg[0] = 'sucesso';
				$msg[1] = 'Usuario editado com sucesso';
			}			
		}
		$retorno = Atletas::find($id);
		$retorno['data_nascimento'] = Funcoes::data($retorno['data_nascimento'],'web');
		$ob = Campus::find($retorno['campus']);
		$instituicoes = Instituicao::all();		
		$campus = Campus::where('instituicao',$ob['instituicao'])->get();
		$retorno['instituicao'] = $ob['instituicao'];
		return view('admin.atletas.formulario')->with('acao','editar')->with('campus',$campus)->with('instituicoes',$instituicoes)->with('retorno',$retorno)->with('msg',$msg);
		
		
	}
	public function novo(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$ob = 0;
			$ob2 = 0;
			$ob3 = 0;
			if($campos['rg'] != '')
				$ob = Atletas::where("rg",$campos['rg'])->where('campus',$campos['campus'])->where("id","<>",$id)->count();
			if($campos['matricula'] != '')
				$ob2 = Atletas::where("matricula",$campos['matricula'])->where('campus',$campos['campus'])->where("id","<>",$id)->count();
			if($campos['cpf'] != '')
				$ob3 = Atletas::where("cpf",$campos['cpf'])->where('campus',$campos['campus'])->where("id","<>",$id)->count();			
			if($ob > 0 or $ob2 > 0 or $ob3 > 0){
				$msg[0] = 'erro';
				$msg[1] = 'Já existe um outro atleta com o mesmo cpf ou rg ou matricula (no mesmo campus)';
			}else{
				$objeto = new Atletas;
				$objeto->nome = $campos['nome'];
				$objeto->data_nascimento = Funcoes::data($campos['data_nascimento'],'db');
				$objeto->campus = $campos['campus'];
				$objeto->sexo = $campos['sexo'];
				$objeto->instituicao = $campos['instituicao'];
				$objeto->matricula = $campos['matricula'];
				$objeto->email = $campos['email'];
				$objeto->telefone = $campos['telefone'];
				$objeto->rg = $campos['rg'];
				$objeto->cpf = $campos['cpf'];
				if(isset($campos['imagem'])) {
					$file = $campos['imagem'];
					$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());            
					$name = $timestamp. '-' .$file->getClientOriginalName();
					$objeto['foto'] = $name;
					$file->move(base_path().'/images/', $name);
				}
				$objeto->save();
				$msg[0] = 'sucesso';
				$msg[1] = 'Usuario cadastrado com sucesso';
			}			
		}
		$instituicoes = Instituicao::all();
		return view('admin.atletas.formulario')->with('acao','novo')->with('instituicoes',$instituicoes)->with('msg',$msg);		
	}	
	function campus($id){
		return Campus::where('instituicao',$id)->get();
	}
	
}
