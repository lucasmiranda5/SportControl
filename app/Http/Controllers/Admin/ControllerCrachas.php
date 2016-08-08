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
		<div style="margin-top:45px; height:680px">
		<img src="<?=App::make('url')->to('/')?>/cracha.jpg" width="500px">
		<img src="<?=App::make('url')->to('/')?>/images/<?=$valor['foto'];?>" style="margin-left: -474px;width: 145px;margin-top: 90px;border-radius: 15px;">
		<div style="margin-top: -276px;margin-left: 190px;width: 280px;font-size: 20px;"><?=@$valor["nome"];?></div>
		<div style="width: 280px;font-size: 20px;margin-top: 55px;margin-left: 47px;"><?=$campus['campus'];?></div>
		<div style="width: 433px;font-size: 20px;margin-top: 65px;margin-left: 37px;"><?=$mods;?></div>
		</div>
		<?php }}
		   }
	
}
