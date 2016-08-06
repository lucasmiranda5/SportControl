<?php

namespace sportcontrol\Http\Controllers\Admin;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Eventos;
use sportcontrol\Modalidade;
use sportcontrol\AtletasModalidade;
use sportcontrol\ModalidadeEvento;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;
use App;

class ControllerFichas extends Controller
{
	public function __construct(){
		  $this->middleware('auth.admin');
	}
    public function index(){
    	$instituicoes = Instituicao::all();
		$eventos = Eventos::all();
		return view('admin.ficha.formulario')->with('instituicoes',$instituicoes)->with("eventos",$eventos);    

			
	}
	public function cabecalho(&$section,$cabecalho){
		$campos = Request::all();
		$evento = Eventos::find($campos['evento']);
		if($evento['por'] == 'C'){
			$cam = Campus::find($campos['campus']);
			$nome = $cam['campus'];
		}else{
			$cam = Instituicao::find($campos['instituicao']);
			$nome = $cam['instituicao'];
		}
			$tableStyle = array(
		    'borderColor' => '000',
		    'borderSize'  => 6,
		);

			$table = $section->addTable($tableStyle);
		$table->addRow();
		$table->addCell(9900, array("bgColor"=>000))->addText($cabecalho,array("bold"=>true,"color"=>'FFFFFF', "size" => "20", "alignment" => "center"));
		$table->addRow();
		$table->addCell(3450,array("bgColor"=>000))->addText("INSTITUIÇÃO/CAMPUS:",array("bold"=>true,"color"=>'FFFFFF'));
		$table->addCell(6450)->addText($nome);
		$table = $section->addTable($tableStyle);
		$table->addRow();
		$table->addCell(3450,array("bgColor"=>000))->addText("TÉCNICO(A):",array("bold"=>true,"color"=>'FFFFFF'));
		$table->addCell(4450)->addText($cam["tecnico"]);
		$table->addCell(1000,array("bgColor"=>000))->addText("SIAPE:",array("bold"=>true,"color"=>'FFFFFF'));
		$table->addCell(1000)->addText($cam['siape']);
		$table = $section->addTable($tableStyle);
		$table->addRow();
		$table->addCell(3450,array("bgColor"=>000))->addText("TELEFONE / CELULAR:",array("bold"=>true,"color"=>'FFFFFF'));
		$table->addCell(6450)->addText($cam['telefone']);
		$table->addRow(); 
		$table->addCell(3450,array("bgColor"=>000))->addText("EMAIL:",array("bold"=>true,"color"=>'FFFFFF'));
		$table->addCell(6450)->addText($cam['email']);
	}
	public function gerar(){
		$campos = Request::all();
		$evento = Eventos::find($campos['evento']);
		$campus = Campus::find($campos['campus']);

		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$sectionStyle = array(
		    'marginTop' => 50,
		    'marginLeft' =>620,
		    'marginRight' =>620
		);
		$section = $phpWord->addSection($sectionStyle);
		$header = $section->addHeader();
		if($evento['imagem1'] != '')
			$header->addImage(App::make('url')->to('/')."/images/".$evento['imagem1']);
		$tableStyle = array(
		    'borderColor' => '000',
		    'borderSize'  => 6,
		);
		// Inicio ficha das modalidades
		self::cabecalho($section,"FICHA DE INSCRIÇÃO DAS MODALIDADES");
		$table = $section->addTable($tableStyle);
		$table->addRow();
		$table->addCell(1000)->addText("N",array("bold"=>true));
		$table->addCell(2600)->addText("MODALIDADE",array("bold"=>true));
		$table->addCell(2100)->addText("MASCULINO",array("bold"=>true));
		$table->addCell(2100)->addText("FEMININO",array("bold"=>true));
		$table->addCell(2100)->addText("N Atletas",array("bold"=>true));

		$modalidades = ModalidadeEvento::where("evento",$campos['evento'])->get();
		$mods = [];
		foreach($modalidades as $moda)
			$mods[] = $moda['modalidade'];
		$retorno = Modalidade::where("sexo","M")->whereIn("id",$mods)->get();
		$x = 1;
		$arr = [];
		
		
		$tableStyle = array(
		    'borderColor' => '000',
		    'borderSize'  => 6,
		);
		foreach($retorno as $valor){
			$table->addRow();
			$table->addCell(1000)->addText($x);
			$table->addCell(2600)->addText($valor['modalidade']);
			
			$retorno2 = AtletasModalidade::where('evento',$campos['evento'])->where('campus',$campos['campus'])->where('modalidade',$valor['id'])->get();
			$table->addCell(2100)->addText(count($retorno2));
			$quant = count($retorno2);
			$retorno3 = Modalidade::where("modalidade",$valor['modalidade'])->where("sexo",'F')->whereIn("id",$mods)->first();
			if(count($retorno3) > 0){
				$retorno2 = AtletasModalidade::where('evento',$campos['evento'])->where('campus',$campos['campus'])->where('modalidade',$retorno3['id'])->get();
				$feminino = count($retorno2);
				$arr[] = $retorno3[0]['id'];

			}else{
				$feminino = 0;
			}
			$table->addCell(2100)->addText($feminino);
			$quant += $feminino;
			$table->addCell(2100)->addText($quant);
			$x++;
		}
		$retorno =Modalidade::where("sexo","F")->whereIn("id",$mods)->whereNotIn("id",$arr)->get();;
		foreach($retorno as $valor){
				$table->addRow();
				$table->addCell(1000)->addText($x);
				$table->addCell(2600)->addText($valor['modalidade']);
				$retorno2 = AtletasModalidade::where('evento',$campos['evento'])->where('campus',$campos['campus'])->where('modalidade',$valor['id'])->get();
				$table->addCell(2100)->addText("0");
				$table->addCell(2100)->addText(count($retorno2));		
				$table->addCell(2100)->addText(count($retorno2));
				$x++;
			
		}

		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		//$phpWord->save('helloWorld.pdf', 'PDF');
		$objWriter->save($campus['campus'].'.docx');

		print "<h1> Arquivo Gerado com sucesso!</h1>";
		?>
		<a href="<?=App::make('url')->to('/')."/".$campus['campus']?>.docx">Baixar Arquivo</a>
<?php

	}	
	
	
}
