<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\CategoriaModalidade;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;

class ControllerCategoriaModalidade extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(CategoriaModalidade::query()->orderBy('id', 'desc'))
			->editColumn('possui_sub',function($model){
				if($model->possui_sub == 'S')
					return 'Sim';
				else
					return 'Não';
			})			
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::categoriamodalidade::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
				</div>';
	   		})->make(true);
	   	}else
			return view('admin.categoriamodalidade.lista');

			
	}
	public function editar($id){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$objeto = CategoriaModalidade::find($id);
			$objeto->nome = $campos['nome'];
			$objeto->possui_sub = $campos['possui_sub'];
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Categoria Editada com sucesso';
			
		}
		$retorno = CategoriaModalidade::find($id);
			return view('admin.categoriamodalidade.formulario')->with('acao','editar')->with('retorno',$retorno)->with('msg',$msg);
		
		
	}
	public function novo(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$objeto =  new CategoriaModalidade;
			$objeto->nome = $campos['nome'];
			$objeto->possui_sub = $campos['possui_sub'];
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Categoria adicionada com sucesso';
		}

		return view('admin.categoriamodalidade.formulario')->with('acao','novo')->with('msg',$msg);		
	}	
	
	
}
