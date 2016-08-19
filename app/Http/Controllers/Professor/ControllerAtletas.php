<?php

namespace sportcontrol\Http\Controllers\Professor;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Usuarios;
use sportcontrol\Atletas;
use sportcontrol\Funcoes;
use sportcontrol\AtletasModalidade;
use sportcontrol\Eventos;
use sportcontrol\Modalidade;
use sportcontrol\ModalidadeCampus;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;
use Auth;
use Carbon\Carbon;

class ControllerAtletas extends Controller
{
	public function __construct(){
		  $this->middleware('auth.user');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(Atletas::query()->where("campus",Auth::user()->campus)->orderBy('id', 'desc'))
			->editColumn('modalidades',function($model){
				$eve = ModalidadeCampus::where('campus',Auth::user()->campus)->get();
		    	$arr = [];
		    	$html = "";
		    	foreach($eve as $ev)
		    		$arr[] = $ev['evento'];
		    	$eventos = Eventos::whereIn("id",$arr)->get();
		    	foreach($eventos as $evento){
		    		$atletas = AtletasModalidade::where('atleta',$model->id)->where('evento',$evento['id'])->get();
		    		$x = 1;
		    		$mods = "";
		    		foreach($atletas as $atleta){
		    			$modalidade = Modalidade::find($atleta['modalidade']);
		    			if($x == 1)
		    				$mods .= $modalidade['modalidade'];
		    			else
		    				$mods .= ",".$modalidade['modalidade'];
		    			$x++;
		    		}
		    		$html .= '<a href="#" data-toggle="tooltip" title="'.$mods.'">'.$evento['nome'].'</a>';
		    	}
		    	return $html;
			})
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('professor::atletas::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
					<a href="'.route('professor::atletas::excluir', $model->id).'"> <i class="fa fa-trash"></i></a>
				</div>';
	   		})->make(true);
	   	}else
			return view('professor.atletas.lista');

			
	}
	public function editar($id){
		
		$retorno = Atletas::find($id);
		if($retorno['campus'] == Auth::user()->campus){
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$ob = 0;
			$ob2 = 0;
			$ob3 = 0;
			if($campos['rg'] != '')
				$ob = Atletas::where("rg",$campos['rg'])->where('campus',Auth::user()->campus)->where("id","<>",$id)->count();
			if($campos['matricula'] != '')
				$ob2 = Atletas::where("matricula",$campos['matricula'])->where('campus',Auth::user()->campus)->where("id","<>",$id)->count();
			if($campos['cpf'] != '')
				$ob3 = Atletas::where("cpf",$campos['cpf'])->where('campus',Auth::user()->campus)->where("id","<>",$id)->count();			
			if($ob > 0 or $ob2 > 0 or $ob3 > 0){
				$msg[0] = 'erro';
				$msg[1] = 'Já existe um outro usuario com o mesmo usuario e/ou email';
			}else{
				$objeto = Atletas::find($id);
				$objeto->nome = $campos['nome'];
				$objeto->data_nascimento = Funcoes::data($campos['data_nascimento'],'db');
				$objeto->sexo = $campos['sexo'];
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
		return view('professor.atletas.formulario')->with('acao','editar')->with('campus',$campus)->with('instituicoes',$instituicoes)->with('retorno',$retorno)->with('msg',$msg);
		}
		
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
				$ob = Atletas::where("rg",$campos['rg'])->where('campus',Auth::user()->campus)->count();
			if($campos['matricula'] != '')
				$ob2 = Atletas::where("matricula",$campos['matricula'])->where('campus',Auth::user()->campus)->count();
			if($campos['cpf'] != '')
				$ob3 = Atletas::where("cpf",$campos['cpf'])->where('campus',Auth::user()->campus)->count();			
			if($ob > 0 or $ob2 > 0 or $ob3 > 0){
				$msg[0] = 'erro';
				$msg[1] = 'Já existe um outro atleta com o mesmo cpf ou rg ou matricula (no mesmo campus)';
			}else{
				$objeto = new Atletas;
				$objeto->nome = $campos['nome'];
				$objeto->data_nascimento = Funcoes::data($campos['data_nascimento'],'db');
				$objeto->campus = Auth::user()->campus;
				$objeto->sexo = $campos['sexo'];
				$campus = Campus::find(Auth::user()->campus);
				$objeto->instituicao = $campus['instituicao'];
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
				$msg[1] = 'Atleta cadastrado com sucesso';
			}			
		}
		$instituicoes = Instituicao::all();
		return view('professor.atletas.formulario')->with('acao','novo')->with('instituicoes',$instituicoes)->with('msg',$msg);		
	}	
	function campus($id){
		return Campus::where('instituicao',$id)->get();
	}

	function excluir($id){
		$atleta = Atletas::find($id);
		if($atleta['campus'] == Auth::user()->campus){
			AtletasModalidade::where('atleta',$id)->delete();
			$atleta->delete();
			$msg[0] = 'sucesso';
			$msg[1] = 'Atleta Excluido com sucesso';
		}else{
			$msg[0] = 'erro';
			$msg[1] = 'Ta tentando burlar o sistema né. Aqui o sistema é bruto #Pirapora';
		}

		return view('professor.atletas.lista')->with('msg',$msg);
		
	}
	
}
