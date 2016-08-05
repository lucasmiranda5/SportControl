<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Modalidade;
use sportcontrol\CategoriaModalidade;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;

class ControllerModalidade extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(Modalidade::query()->orderBy('id', 'desc'))
			->editColumn('categoria',function($model){
				$o = CategoriaModalidade::find($model->categoria);
				return $o['nome'];
			})
			->editColumn('sexo',function($model){
				if($model->sexo == 'M')
					return 'Masculino';
				elseif($model->sexo == 'F')
					return 'Feminino';
				else
					return "Misto";
			})			
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::modalidades::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
				</div>';
	   		})->make(true);
	   	}else
			return view('admin.modalidades.lista');

			
	}
	public function editar($id){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
						
			$objeto = Modalidade::find($id);
			$objeto->modalidade = $campos['nome'];
			$objeto->categoria = $campos['categoria'];
			$objeto->sexo = $campos['sexo'];
			if(!empty($campos['sub']))
				$objeto->sub = $campos['sub'];			
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Usuario editado com sucesso';
					
		}
		$retorno = Modalidade::find($id);
		$categorias = CategoriaModalidade::all();
		$mods = Modalidade::whereNull('sub')->orWhere('sub','0')->get();	
		return view('admin.modalidades.formulario')->with('acao','editar')->with('categorias',$categorias)->with('retorno',$retorno)->with('modalidades',$mods)->with('msg',$msg);
		
		
	}
	public function novo(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			
			$objeto = new Modalidade;
			$objeto->modalidade = $campos['nome'];
			$objeto->categoria = $campos['categoria'];
			$objeto->sexo = $campos['sexo'];
			if(!empty($campos['sub']))
				$objeto->sub = $campos['sub'];	
			$objeto->save();		
		}
		$categorias = CategoriaModalidade::all();	
		$mods = Modalidade::whereNull('sub')->orWhere('sub','0')->orWhere('sub','')->get();
		return view('admin.modalidades.formulario')->with('acao','novo')->with('modalidades',$mods)->with('categorias',$categorias)->with('msg',$msg);		
	}	

	
}
