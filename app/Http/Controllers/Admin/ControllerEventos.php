<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Eventos;
use sportcontrol\Funcoes;
use sportcontrol\ModalidadeEvento;
use sportcontrol\Modalidade;
use sportcontrol\ModalidadeCampus;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;

class ControllerEventos extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function listar(){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(Eventos::query()->orderBy('id', 'desc'))		
			->editColumn('data_fim',function($model){
				return Funcoes::data($model->data_fim,'web');
			})	
			->editColumn('data_inicio',function($model){
				return Funcoes::data($model->data_inicio,'web');
			})	
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::eventos::editar', $model->id).'"> <i class="fa fa-edit"></i></a>
					<a class="btn btn-xs btn-info" href="'.route('admin::eventos::modalidades::listar', $model->id).'">Modalidades</a>
					<a class="btn btn-xs btn-info" href="'.route('admin::eventos::participantes', $model->id).'">Participantes</a>
				</div>';
	   		})->make(true);
	   	}else
			return view('admin.eventos.lista');			
	}
	public function listarModalidade($id){
    	if(!empty(Request::input('columns'))){
			return Datatables::of(ModalidadeEvento::query()->where("evento",$id)->orderBy('id', 'desc'))		
			->editColumn('modalidade',function($model){
				$mod = Modalidade::find($model->modalidade);
				return $mod['modalidade'];
			})	
			->editColumn('data_limite',function($model){
				return Funcoes::data($model->data_limite,'web');
			})	
	   		->editColumn('acoes',function($model){
	   			return'
	   			 <div class="tools">						   
					<a href="'.route('admin::eventos::modalidades::editar', [$model->evento,$model->id]).'"> <i class="fa fa-edit"></i></a>
					<a href="'.route('admin::eventos::modalidades::excluir', [$model->evento,$model->id]).'"> <i class="fa fa-trash"></i></a>
				
				</div>';
	   		})->make(true);
	   	}else{
	   		$evento = Eventos::find($id);
			return view('admin.eventos.listaModalidade')->with('evento',$evento);			
	   	}
	}
	public function editar($id){
		
		$acao = Request::input('acao');
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$objeto = Eventos::find($id);
			$objeto->nome = $campos['nome'];
			$objeto->por = $campos['por'];
			$objeto->site = $campos['site'];
			$objeto->data_inicio = Funcoes::data($campos['data_inicio'],'db');
			$objeto->data_fim = Funcoes::data($campos['data_fim'],'db');
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Campus adicionada com sucesso';
			
		}
		$retorno = Eventos::find($id);
			return view('admin.eventos.formulario')->with('acao','editar')->with('retorno',$retorno)->with('msg',$msg);
		
		
	}
	public function novo(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$objeto =  new Eventos;
			$objeto->nome = $campos['nome'];
			$objeto->por = $campos['por'];
			$objeto->site = $campos['site'];
			$objeto->data_inicio = Funcoes::data($campos['data_inicio'],'db');
			$objeto->data_fim = Funcoes::data($campos['data_fim'],'db');
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Campus adicionada com sucesso';
		}
		return view('admin.eventos.formulario')->with('acao','novo')->with('msg',$msg);		
	}	
	public function novoModalidade($id){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$objeto =  new ModalidadeEvento;
			$objeto->evento = $id;
			$objeto->modalidade = $campos['modalidade'];
			$objeto->maximo = $campos['maximo'];
			$objeto->data_limite = Funcoes::data($campos['data_limite'],'db');
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Modalidade veinculada com sucesso';
		}
		$mod = ModalidadeEvento::where('evento',$id)->get();
		$mods = [];
		foreach($mod as $a)
			$mods[] = $a['modalidade'];
		$modalidades = Modalidade::whereNotIn('id',$mods)->get();
		return view('admin.eventos.formularioModalidade')->with('acao','novo')->with('msg',$msg)->with("modalidades",$modalidades);		
	}

	public function participantes($id){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){
			$camp = $campos['modalidade'];
			$campus = $campos['campus'];
			$mods = [];
			foreach($camp as $key => $valor){
				if($valor == 'S'){
					$ob = ModalidadeEvento::find($key);
					$mo = ModalidadeCampus::where('campus',$campus)->where('modalidade',$ob['modalidade'])->where('evento',$ob['evento'])->count();
					if($mo == 0){
						$m = new ModalidadeCampus;
						$m->modalidade = $ob['modalidade'];
						$m->campus = $campus;
						$m->evento = $ob['evento'];
						$m->save();
						$mods[] = $m['id'];
					}else{
						$mo = ModalidadeCampus::where('campus',$campus)->where('modalidade',$ob['modalidade'])->where('evento',$ob['evento'])->get();
						$mods[] = $mo[0]['id'];
					}

				}
			}
			$mo = ModalidadeCampus::where('campus',$campus)->where('evento',$ob['evento'])->get();
			foreach($mo as $m){
				if(!in_array($m['id'], $mods)){
					$a = ModalidadeCampus::find($m['id']);
					$a->delete();
				}
			}
			$msg[0] = 'sucesso';
			$msg[1] = 'Modalidade veinculada com sucesso';
		}		
		$instituicao = Instituicao::all();
		$evento = Eventos::find($id);
		return view('admin.eventos.participantes')->with('acao','novo')->with('msg',$msg)->with("instituicoes",$instituicao)->with('evento',$evento);		
	}

	public function editarModalidade($evento,$id){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'editar' and Request::input('_token')){
			$objeto =  ModalidadeEvento::find($id);
			$objeto->maximo = $campos['maximo'];
			$objeto->data_limite = Funcoes::data($campos['data_limite'],'db');
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Modalidade editada com sucesso';
		}
		$retorno = ModalidadeEvento::find($id);		
		$modalidades = Modalidade::find($retorno['modalidade']);
		$retorno['data_limite'] = Funcoes::data($retorno['data_limite'],'web');
		return view('admin.eventos.formularioModalidade')->with('acao','editar')->with('msg',$msg)->with("modalidades",$modalidades)->with('retorno',$retorno);		
	}

	public function gerarModalidades($evento,$campus){
		$eventos = Eventos::find($evento);
		if($eventos['por'] == 'C'){			
			$mods = ModalidadeEvento::where('evento',$evento)->get();
			foreach($mods as $mod){
				$modalidade = Modalidade::find($mod['modalidade']);
				$mo = ModalidadeCampus::where('campus',$campus)->where('modalidade',$mod['modalidade'])->where('evento',$evento)->count();
				$che = ($mo > 0 ? 'checked': '');
				print '
				<div class="checkbox">
                  <label>
                    <input '.$che.' name="modalidade['.$mod['id'].']" value="S" type="checkbox">'.$modalidade['modalidade'].'
                  </label>
                </div>';
			}
		}else{
			$mods = ModalidadeEvento::where('evento',$evento)->get();
			$campu = Campus::find($campus);
			$cam = Campus::where("instituicao",$campu['instituicao'])->get();
			$c = [];
			foreach($cam as $valor)
				$c[] = $valor['id'];

			foreach($mods as $mod){
				$modalidade = Modalidade::find($mod['modalidade']);
				$mo2 = ModalidadeCampus::whereIn('campus',$c)->where('modalidade',$mod['modalidade'])->where('evento',$evento)->get();
				if($mo2[0]['campus'] == $campus){
					$mo = ModalidadeCampus::where('campus',$campus)->where('modalidade',$mod['modalidade'])->where('evento',$evento)->count();
					$che = ($mo > 0 ? 'checked': '');
					print '
					<div class="checkbox">
	                  <label>
	                    <input '.$che.' name="modalidade['.$mod['id'].']" value="S" type="checkbox">'.$modalidade['modalidade'].'
	                  </label>
	                </div>';
            	}
			}
		}
	}
	
	
}
