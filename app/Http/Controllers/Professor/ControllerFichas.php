<?php

namespace sportcontrol\Http\Controllers\Professor;

use sportcontrol\Http\Requests;
use sportcontrol\Instituicao;
use sportcontrol\Campus;
use sportcontrol\Eventos;
use sportcontrol\Atletas;
use sportcontrol\CategoriaModalidade;
use sportcontrol\Modalidade;
use sportcontrol\AtletasModalidade;
use sportcontrol\ModalidadeEvento;
use sportcontrol\ModalidadeCampus;
use sportcontrol\Http\Controllers\Controller;
use Request;
use Datatables;
use App;
use Auth;

class ControllerFichas extends Controller
{
	public function __construct(){
		  $this->middleware('auth.user');
	}
    public function index(){
    	$eve = ModalidadeCampus::where('campus',Auth::user()->campus)->get();
    	$arr = [];
    	foreach($eve as $ev)
    		$arr[] = $ev['evento'];
		$eventos = Eventos::whereIn("id",$arr)->get();
		return view('professor.ficha.formulario')->with("eventos",$eventos);    

			
	}
	public function cabecalho(&$section,$cabecalho){
		$campos = Request::all();
		$evento = Eventos::find($campos['evento']);
		if($evento['por'] == 'C'){
			$cam = Campus::find(Auth::user()->campus);
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
		$campus = Campus::find(Auth::user()->campus);

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
			
			$retorno2 = AtletasModalidade::where('evento',$campos['evento'])->where('campus',Auth::user()->campus)->where('modalidade',$valor['id'])->get();
			$table->addCell(2100)->addText(count($retorno2));
			$quant = count($retorno2);
			$retorno3 = Modalidade::where("modalidade",$valor['modalidade'])->where("sexo",'F')->whereIn("id",$mods)->first();
			if(count($retorno3) > 0){
				$retorno2 = AtletasModalidade::where('evento',$campos['evento'])->where('campus',Auth::user()->campus)->where('modalidade',$retorno3['id'])->get();
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
				$retorno2 = AtletasModalidade::where('evento',$campos['evento'])->where('campus',Auth::user()->campus)->where('modalidade',$valor['id'])->get();
				$table->addCell(2100)->addText("0");
				$table->addCell(2100)->addText(count($retorno2));		
				$table->addCell(2100)->addText(count($retorno2));
				$x++;
			
		}
		$section->addText("OBS: TODAS AS ASSINATURAS DEVEM SEGUIR COM CARIMBO DO ASSINANTE.");
				$section->addText("");
				$section->addText("");
				$table = $section->addTable($tableStyle);
				$table->addRow();

				$table->addCell(5000)->addText("                            DECLARAÇÃO                                  DECLARO que os alunos(as) supracitados atendem ao que dispõe o Art. 08 do Regulamento Geral do JIFENMG. 
Art. 8° - Poderão participar dos JIFENMG 2016 os alunos regularmente matriculados nos diversos Campi do IFNMG, com idade até 19 (dezenove) anos (nascidos em 1997), frequentando regularmente, no mínimo, uma disciplina de curso regular e com frequência superior ou igual a 75%.",array("bold"=>true));
				$section->addText("");
				$section->addText("");
				$section->addText("");
				$section->addText("____________________________________                                    ______________________________  ");

				$section->addText("               PROFESSOR/TREINADOR                                                  DIRETORIA/SECRETARIA GERAL  ");

				$section->addText("");
				$section->addText("");
				$section->addText("");
				$section->addText("                                                                              _____________________ , ______ de ______________ ".date('Y').".");

		//Ficha de inscrição individual
			// Fim das fichas dos atletas
		$sectionStyle = array(
		    'marginTop' => 50,
		    'marginLeft' =>620,
		    'marginRight' =>620,
		    'orientation' => 'landscape',
		);
		$section = $phpWord->addSection($sectionStyle);
		$modalid = ModalidadeEvento::where('evento',$campos['evento'])->get();
		$arr = [];
		foreach($modalid as $mod){
			$arr[] = $mod['id'];
		}
		$modalid = Modalidade::whereIn('id',$arr)->where(function($query){
			$query->whereNull("sub")->orWhere("sub","")->orWhere("sub",0);})->get();
		$cats = [];
		foreach($modalid as $mod){
			if(!in_array($mod['categoria'], $cats))
				$cats[] = $mod['categoria'];
		}
		$modalidades = [];
		foreach($cats as $cat){
			$x = 0;
			$modalid = Modalidade::whereIn('id',$arr)->where(function($query){
			$query->whereNull("sub")->orWhere("sub","")->orWhere("sub",0);})->where('categoria',$cat)->where('sexo','M')->get();
			foreach($modalid as $valor){
				$mod = Modalidade::whereIn('id',$arr)->where('modalidade',$valor['modalidade'])->first();
				$modalidades[$cat][$x]['nome'] = $valor['modalidade'];
				$modalidades[$cat][$x]['masculino'] = $valor['id'];
				if(count($mod) > 0){
					$modalidades[$cat][$x]['feminino'] = $mod['id'];
				}else
					$modalidades[$cat][$x]['feminino'] = '';
				$x++;
			}
		}
		$sectionStyle = array(
		    'marginTop' => 50,
		    'marginLeft' =>620,
		    'marginRight' =>620,
		    'orientation' => 'landscape',
		);
		$section = $phpWord->addSection($sectionStyle);
		self::cabecalho($section,"FICHA GERAL DE INSCRIÇÃO INDIVIDUAL");

		$table = $section->addTable($tableStyle);

		$cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
		$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
		//$cellColSpan = ;
		$cellVCentered = array('valign' => 'center');
		$cellRowContinue = array('vMerge' => 'continue');

		$row = $table->addRow();
		
		$cell1 = $table->addCell(3608,array('gridSpan' => 2, 'valign' => 'center'));
		$textrun1 = $cell1->addTextRun($cellHCentered);
		$textrun1->addText('MODALIDADES');

		$tamanho = (int)(11216/count($cats));
		foreach($cats as $cat){
			$ca = CategoriaModalidade::find($cat);
			$cell2 = $table->addCell($tamanho, array('gridSpan' => (int)count($modalidades[$cat]), 'valign' => 'center'));
			$textrun2 = $cell2->addTextRun($cellHCentered);
			$textrun2->addText($ca['nome']);
		}

		$cell1 = $table->addCell(975, $cellRowSpan);
		$textrun1 = $cell1->addTextRun($cellHCentered);
		$textrun1->addText('MODALIDADES');
		
		$table->addRow();
		$table->addCell(3608,array('gridSpan' => 2, 'valign' => 'center'))->addText('Alunos');

		foreach($cats as $cat){
			foreach($modalidades[$cat] as $m)
				$table->addCell($tamanho/count($modalidades[$cat]), $cellVCentered)->addText($m['nome']);
		}
		$table->addCell(975, $cellRowContinue);

		$atletas = Atletas::where('campus',Auth::user()->campus)->get();
		$x = 1;
		
		foreach($atletas as $valor){
			$quant = 0;
			$table->addRow();
			$table->addCell(500)->addText($x);
			$table->addCell(3108)->addText($valor['nome']);
			foreach($cats as $cat){
				foreach($modalidades[$cat] as $m){
					if($valor['sexo'] == 'M')
						$at = AtletasModalidade::where('atleta',$valor['id'])->where('modalidade',$m['masculino'])->where("evento",$campos['evento'])->count();
					else{
						if($m['feminino'] != '')
							$at = AtletasModalidade::where('atleta',$valor['id'])->where('modalidade',$m['feminino'])->where("evento",$campos['evento'])->count();
						else
							$at = 0;
					}
					if($at > 0){
						$table->addCell($tamanho/count($modalidades[$cat]))->addText("X");
						$quant++;
					}else
						$table->addCell($tamanho/count($modalidades[$cat]))->addText("");
				}
			}
			$table->addCell(975)->addText($quant);
			$x++;
		}
		$section->addText("OBS: TODAS AS ASSINATURAS DEVEM SEGUIR COM CARIMBO DO ASSINANTE.");
				$section->addText("");
				$section->addText("");
				$table = $section->addTable($tableStyle);
				$table->addRow();

				$table->addCell(5000)->addText("                            DECLARAÇÃO                                  DECLARO que os alunos(as) supracitados atendem ao que dispõe o Art. 08 do Regulamento Geral do JIFENMG. 
Art. 8° - Poderão participar dos JIFENMG 2016 os alunos regularmente matriculados nos diversos Campi do IFNMG, com idade até 19 (dezenove) anos (nascidos em 1997), frequentando regularmente, no mínimo, uma disciplina de curso regular e com frequência superior ou igual a 75%.",array("bold"=>true));
				$section->addText("");
				$section->addText("");
				$section->addText("");
				$section->addText("____________________________________                                    ______________________________  ");

				$section->addText("               PROFESSOR/TREINADOR                                                  DIRETORIA/SECRETARIA GERAL  ");

				$section->addText("");
				$section->addText("");
				$section->addText("");
				$section->addText("                                                                              _____________________ , ______ de ______________ ".date('Y').".");


		$section = $phpWord->addSection(array(
				    'marginTop' => 50,
				    'marginLeft' =>620,
				    'marginRight' =>620,
				));
		//INicio fica inscrição por modalidade

		$retorno = ModalidadeCampus::where("campus",Auth::user()->campus)->where("evento",$campos['evento'])->get();
		foreach($retorno as $valor){
			$retorno2 = AtletasModalidade::where("campus",Auth::user()->campus)->where("evento",$campos['evento'])->where("modalidade",$valor['modalidade'])->get();
			if(count($retorno2)){
				$modalidade = Modalidade::find($valor['modalidade']);
				$section = $phpWord->addSection(array(
				    'marginTop' => 50,
				    'marginLeft' =>620,
				    'marginRight' =>620,
				));
				$tableStyle = array(
				    'borderColor' => '000',
				    'borderSize'  => 6,
				);
				$campus = Campus::find(Auth::user()->campus);
				$table = $section->addTable($tableStyle);
				$table->addRow();
				$table->addCell(9900, array("bgColor"=>000))->addText("FICHA DE INSCRIÇÃO",array("bold"=>true,"color"=>'FFFFFF', "size" => 10, "alignment" => "center"));
				$table->addRow();
				$table->addCell(9900, array("bgColor"=>000))->addText($modalidade['modalidade'].' - '.($modalidade['sexo'] == 'F' ? 'Feminino' : 'Masculino'),array("bold"=>true,"color"=>'FFFFFF', "size" => "18", "alignment" => "center"));
				$table->addRow();
				$table->addCell(3450,array("bgColor"=>000))->addText("INSTITUIÇÃO/CAMPUS:",array("bold"=>true,"color"=>'FFFFFF'));
				$table->addCell(6450)->addText($campus['campus']);
				$table = $section->addTable($tableStyle);
				$table->addRow();
				$table->addCell(3450,array("bgColor"=>000))->addText("TÉCNICO(A):",array("bold"=>true,"color"=>'FFFFFF'));
				$table->addCell(4450)->addText(($valor['tecnico'] != '' ? $valor['tecnico'] : $cam['tecnico']) );
				$table->addCell(1000,array("bgColor"=>000))->addText("SIAPE:",array("bold"=>true,"color"=>'FFFFFF'));
				$table->addCell(1000)->addText(($valor['siape'] != '' ? $valor['siape'] : $cam['siape']));
				$table = $section->addTable($tableStyle);
				$table->addRow();
				$table->addCell(3450,array("bgColor"=>000))->addText("TELEFONE / CELULAR:",array("bold"=>true,"color"=>'FFFFFF'));
				$table->addCell(6450)->addText(($valor['telefone'] != '' ? $valor['telefone'] : $cam['telefone']));
				$table->addRow(); 
				$table->addCell(3450,array("bgColor"=>000))->addText("EMAIL:",array("bold"=>true,"color"=>'FFFFFF'));
				$table->addCell(6450)->addText(($valor['email'] != '' ? $valor['email'] : $cam['email']));
				
				$table = $section->addTable($tableStyle);
				$table->addRow();
				$table->addCell(500)->addText("N");	
				$table->addCell(3961)->addText("Nome");	
				$table->addCell(1813)->addText("Data Nasc");	
				$table->addCell(1813)->addText("REG IFET");	
				$table->addCell(1813)->addText("N Doc");
				$x = 1;
				foreach($retorno2 as $valor2){
					$atleta = Atletas::find($valor2['atleta']);
					$table->addRow();
					$table->addCell(500)->addText($x);	
					$table->addCell(3961)->addText($atleta['nome']);	
					$table->addCell(1813)->addText(date('d/m/Y',strtotime($atleta['data_nascimento'])));	
					$table->addCell(1813)->addText($atleta['matricula']);	
					$table->addCell(1813)->addText($atleta['rg']);
					$x++;
				}
				for($x; $x <= $valor['maximo']; $x++){
					$table->addRow();
					$table->addCell(500)->addText($x);	
					$table->addCell(3961)->addText("");	
					$table->addCell(1813)->addText("");	
					$table->addCell(1813)->addText("");	
					$table->addCell(1813)->addText("");
				}
				$section->addText("OBS: TODAS AS ASSINATURAS DEVEM SEGUIR COM CARIMBO DO ASSINANTE.");
				$section->addText("");
				$section->addText("");
				$table = $section->addTable($tableStyle);
				$table->addRow();

				$table->addCell(5000)->addText("                            DECLARAÇÃO                                  DECLARO que os alunos(as) supracitados atendem ao que dispõe o Art. 08 do Regulamento Geral do JIFENMG. 
Art. 8° - Poderão participar dos JIFENMG 2016 os alunos regularmente matriculados nos diversos Campi do IFNMG, com idade até 19 (dezenove) anos (nascidos em 1997), frequentando regularmente, no mínimo, uma disciplina de curso regular e com frequência superior ou igual a 75%.",array("bold"=>true));
				$section->addText("");
				$section->addText("");
				$section->addText("");
				$section->addText("____________________________________                                    ______________________________  ");

				$section->addText("               PROFESSOR/TREINADOR                                                  DIRETORIA/SECRETARIA GERAL  ");

				$section->addText("");
				$section->addText("");
				$section->addText("");
				$section->addText("                                                                              _____________________ , ______ de ______________ ".date('Y').".");
				$section = $phpWord->addSection(array(
				    'marginTop' => 50,
				    'marginLeft' =>620,
				    'marginRight' =>620,
				));
			}

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
