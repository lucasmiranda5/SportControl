<?php

namespace sportcontrol\Http\Controllers\Professor;

use sportcontrol\Http\Requests;
use sportcontrol\Modalidade;
use sportcontrol\ModalidadeCampus;
use sportcontrol\Funcoes;
use sportcontrol\Eventos;
use sportcontrol\ModalidadeEvento;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;
use Auth;
use Carbon\Carbon;

class ControllerModalidades extends Controller
{
	public function __construct(){
		  $this->middleware('auth.user');
	}
    public function listar(){
    	$eve = ModalidadeCampus::where('campus',Auth::user()->campus)->get();
    	$arr = [];
    	foreach($eve as $ev)
    		$arr[] = $ev['evento'];
    	return view("professor.modalidades")->with("eventos",Eventos::whereIn("id",$arr)->get());    	
	}

	public function modalidades ($evento){
		return Datatables::of(ModalidadeCampus::query()->where('campus',Auth::user()->campus)->where('evento',$evento)->orderBy('id', 'desc'))
			->editColumn('modalidade',function($model){
				$modalidade = Modalidade::find($model->modalidade);
				return $modalidade['modalidade'];
			})		
			->editColumn('campus',function($model){
				$modalidade = Modalidade::find($model->modalidade);
				return ($modalidade['sexo'] == 'M' ? 'Masculino' : 'Feminino');
			})
			->editColumn('maximo',function($model){
				$modalidade = ModalidadeEvento::where('modalidade',$model->modalidade)->where('evento',$model->evento)->first();
				return $modalidade['maximo'];
			})
			->make(true);
	}

	
	
}
