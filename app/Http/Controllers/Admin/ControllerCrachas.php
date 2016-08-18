<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\AtletasModalidade;
use sportcontrol\Atletas;
use sportcontrol\Modalidade;
use sportcontrol\Usuarios;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;
use App;

class ControllerCrachas extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
   public function gerar(){?>
   	<html>
	<head>


<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
	<link href="<?=App::make('url')->to('/')?>/resources/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?=App::make('url')->to('/')?>/resources/assets/dist/css/AdminLTE.css" />
<link href="<?=App::make('url')->to('/')?>/resources/assets/dist/css/skins/_all-skins.min.css" />
<style>
	body{ margin:0; padding: 0; }
</style>

	</head>
	<body>
	<?php
		$retorno = Atletas::all();
		foreach($retorno as $valor){
			if($valor['nome'] != ''){
			$campus = Campus::find($valor['campus']);
			$modalidades = AtletasModalidade::where('atleta',$valor['id'])->get();
			$mods = "";
			$x = 1;
			foreach($modalidades as $valor2){
				$modal = Modalidade::find($valor2['modalidade']);
				if($modal['sub'] == $modal['id'] or is_null($modal['sub'])){
					if($x == 1)
						$mods = $modal['modalidade'];				
					else
						$mods .=", ".$modal['modalidade'];			
					$x++;
				}
			}
			?>
		<div style="margin-top:45px; height:544px; width:50%; float:left">
		<img src="<?=App::make('url')->to('/')?>/cracha.jpg" width="400px">
		<?php if($valor['foto'] != '' and file_exists(base_path().'/images/'.$valor['foto'])) { ?>
			<img src="<?=App::make('url')->to('/')?>/images/<?=$valor['foto'];?>" style="margin-left: -380px;width: 115px;margin-top: 69px;border-radius: 15px;height: 130px;">
		<?php } ?>
		<div style="margin-top: -220px;margin-left: 153px;width: 224px;font-size: 14px;"><?=@$valor["nome"];?></div>
		<div style="width: 280px;font-size: 20px;margin-top: 60px;margin-left: 47px;"><?=$campus['campus'];?></div>
		<div style="width: 433px;font-size: 20px;margin-top: 45px;margin-left: 37px;"><?=$mods;?></div>
		</div>
		<?php }}
		   }
	
}
