<?php

namespace sportcontrol\Http\Controllers\Professor;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Usuarios;
use sportcontrol\Atletas;
use sportcontrol\Eventos;
use sportcontrol\Modalidade;
use sportcontrol\AtletasModalidade;
use sportcontrol\ModalidadeCampus;
use sportcontrol\Funcoes;
use sportcontrol\ModalidadeEvento;
use sportcontrol\Http\Controllers\Controller;
use Request;
use App;
use Auth;
use Datatables;
use Carbon\Carbon;

class ControllerAtletasModalidade extends Controller
{
	public function __construct(){
		  $this->middleware('auth.user');
	}
    public function formulario(){
		$acao = Request::input('acao');
		$retorno = [];
		$msg = [];
		$campos = Request::all();
		if($acao == 'novo' and Request::input('_token')){	
			$atletas = $campos['atletasMulti'];
			$arr = [];
			foreach($atletas as $atleta){
				$tem = AtletasModalidade::where('atleta',$atleta)->where("modalidade",$campos['modalidade'])->where("evento",$campos['evento'])->count();
				if($tem == 0){
					$at = new AtletasModalidade;
					$at->atleta = $atleta;
					$at->modalidade = $campos['modalidade'];
					$at->evento = $campos['evento'];
					$at->campus = Auth::user()->campus;
					$at->save();
					$arr[] = $at['id'];
				}else{
					$tem = AtletasModalidade::where('atleta',$atleta)->where("modalidade",$campos['modalidade'])->where("evento",$campos['evento'])->get();
					$arr[] = $tem['id'];
				}
			}
			$atletas = AtletasModalidade::where("modalidade",$campos['modalidade'])->where("evento",$campos['evento'])->get();
			foreach($atletas as $atleta){
				if(!in_array($atleta['id'], $arr)){
					AtletasModalidade::find($atleta['id'])->delete();
				}
			}
			$objeto = ModalidadeCampus::where("modalidade",$campos['modalidade'])->where("evento",$campos['evento'])->where("campus",Auth::user()->campus)->first();
			$objeto->tecnico = $campos['tecnico'];
			$objeto->siape = $campos['siape'];
			$objeto->email = $campos['email'];
			$objeto->telefone = $campos['telefone'];
			$objeto->save();
			$msg[0] = 'sucesso';
			$msg[1] = 'Equipe registrada com sucesso';
		}
		$eve = ModalidadeCampus::where('campus',Auth::user()->campus)->get();
    	$arr = [];
    	foreach($eve as $ev)
    		$arr[] = $ev['evento'];

		$eventos = Eventos::whereIn("id",$arr)->get();
		return view('professor.equipe.formulario')->with('acao','novo')->with('msg',$msg)->with("eventos",$eventos);		
	}	
	function campus($id){
		return Campus::where('instituicao',$id)->get();
	}
	function modalidades(){
		$campos = Request::all();
		$mod = ModalidadeCampus::where("evento",$campos['evento'])->where("campus",Auth::user()->campus)->get();
		$arr = [];
		$x = 0;
		foreach($mod as $m){
			$moda = Modalidade::find($m['modalidade']);
			$arr[$x]['id'] = $m['modalidade'];
			$arr[$x]['nome'] = $moda['modalidade'];
			$arr[$x]['sexo'] = $moda['sexo'];
			$x++;
		}
		return $arr;
	}
	function chamarAtletas(){
		$campos = Request::all();
		$retorno = Modalidade::find($campos['modalidade']);
		$ret = ModalidadeEvento::where('modalidade',$campos['modalidade'])->where('evento',$campos['evento'])->first();
		if($retorno['sub']== $retorno['id'] or $retorno['sub'] == ''){
			$retorno2 = Atletas::where("sexo",$retorno['sexo'])->where("campus",Auth::user()->campus)->get();
			foreach($retorno2 as $result){
					$ar[$result['id']] = $result['nome'];				
			}
		}else{
			$retorno2 = AtletasModalidade::where('modalidade',$retorno['sub'])->where("evento",$campos['evento'])->where("campus",Auth::user()->campus)->get();
			foreach($retorno2 as $r){
				$r2 = Atletas::find($r['atleta']);
				$ar[$r2['id']] = $r2['nome'];		
				$r3[] = $r2;				
			}		
			 @$retorno2 = $r3;
		}
		$retorno3 =AtletasModalidade::where("modalidade",$campos['modalidade'])->where('campus',Auth::user()->campus)->where('evento',$campos['evento'])->get();
		?>
		<script src="<?=App::make('url')->to('/');?>/resources/assets/js/jquery.ui.widget.js"></script>
		<script src="<?=App::make('url')->to('/');?>/resources/assets/js/jquery-picklist.js"></script>

		<script>
		$(function()
{
    $("#advanced").pickList(
    {
        sourceListLabel:    "Seus Atletas",
        targetListLabel:    "Atletas Inscritos",
        
        addLabel:           "Adicionar",
        removeAllLabel:     "Remover Todos",
        removeLabel:        "Remover",
        sortAttribute:      "value",
		selectLimit : <?=$ret['maximo']?>,

		<?php
		$arr = [];
		if(count($retorno3) > 0){
			print "items:
        [";
		foreach($retorno3 as $val3){
			print '{
					value: '.$val3['atleta'].',
					label: "'.$ar[$val3['atleta']].'",
					selected:true,
				
			},';
			$arr[] = $val3['atleta'];
		}
			print "],";
		}		
		?>
      
    });	
});
</script>
<style>
.pickList_sourceListContainer, .pickList_controlsContainer, .pickList_targetListContainer { float: left; margin: 0.25em; }
.pickList_controlsContainer { text-align: center; }
.pickList_controlsContainer button { display: block; width: 100%; text-align: center; border:0px;background-color: #87B87F !important; padding: 10px;margin: 10px 0;}
.pickList_list { list-style-type: none; margin: 0; padding: 0; float: left; width: 300px; height: 500px; border: 1px solid #000; overflow-y: auto; cursor: default; }
.pickList_selectedListItem { background-color: #a3c8f5; }
.pickList_listLabel { font-size: 0.9em; font-weight: bold; text-align: center; }
.pickList_clear { clear: both; }
</style>
<div>
    <select id="advanced" name="atletasMulti[]" multiple="multiple">
        
    
		<?php
	foreach($retorno2 as $result){
				if(!in_array($result['id'],$arr))
					print "<option value='".$result['id']."'>".$result['nome']."</option>";
	}
	$ret = ModalidadeCampus::where('campus',Auth::user()->campus)->where('modalidade',$campos['modalidade'])->first();

?>
</select>
</div>
</div>
<h3> Informações do Técnico</h3>
<div class="form-group">
  <label for="campus">Nome</label>
  <input class="form-control" id="tecnico" name="tecnico" value="<?=$ret['tecnico'];?>" placeholder="Nome" type="text" >
</div>
<div class="form-group">
  <label for="campus">SIAPE</label>
  <input class="form-control" id="siape" name="siape" value="<?=$ret['siape'];?>"" placeholder="SIAPE" type="text" >
</div>
<div class="form-group">
	<label for="telefone">Telefone</label>
	<input class="form-control" id="telefone" name="telefone" value="<?=$ret['telefone'];?>" placeholder="Telefone" type="text" >
</div>
<div class="form-group">
	<label for="campus">Email</label>
	<input class="form-control" id="email" name="email" value="<?=$ret['email'];?>" placeholder="Email" type="text" >
</div>
		<?php

	}
	
}
