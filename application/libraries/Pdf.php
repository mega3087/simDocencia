<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Incluimos el archivo fpdf
require_once 'assets\\fpdf\\fpdf.php';	

//Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
class Pdf extends FPDF {
	public function __construct() {
		parent::__construct();
	}
	// El encabezado del PDF
	public function Header(){
		$top = 10;	
		$this->SetFont('Arial','B',8);
		//$this->Image('assets/img/logo_engrande.png',15,$this->h-60,200,60);
/*		$this->Image('assets/img/edo_logo.png',15,$top,45);
		$w = $this -> w; // Width of Current Page
		$this->Image('assets/img/logo2p.png',$w-30,$top,20);
		$this->Image('assets/img/logo_engrande.png',15,$this->h-60,200,60);
*/
	$this->SetFillColor(150,152,154);
	}
	// El pie del pdf
	public function Footer(){
		$this->SetY(-26);
		$this->SetFont('Arial','B',8);
		$name=$this->name;
		$page=$this->page;
		
		if ($name =='FO-CON-02' or $name =='FO-CON-03' or $name =='FO-CON-05' /*or ($name =='FO-CON-04' and $page < 3)*/ or $name=='Solicitud'){
			$top = 10;
			$this->Image('assets/img/edo_logo.png',15,$top,45);
			$w = $this -> w; // Width of Current Page
			$this->Image('assets/img/logo2p.png',$w-30,$top,20);
			$this->Image('assets/img/logo_engrande.png',15,$this->h-60,200,60);
		}
		
		if ($name =='FO-CON-02' or $name =='FO-CON-03' or $name =='FO-CON-05' /*or ($name =='FO-CON-04' and $page < 3)*/){	
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(255,255,255);
			if($name == 'FO-CON-02'){
				$this->MultiCell(0,4, utf8_decode('SECRETARÍA DE LA CONTRALORÍA
DEPARTAMENTO DE RECURSOS MATERIALES
SUBDIRECCIÓN DE ADMINISTRACIÓN DE RECURSOS'),0,'R');
			}else if($name == 'FO-CON-03'){
				$this->MultiCell(0,4, utf8_decode('SECRETARÍA DE LA CONTRALORÍA
COORDINACIÓN DE ADMINISTRACIÓN
SUBDIRECCIÓN DE ADMINISTRACIÓN DE RECURSOS'),0,'R');
			}else{
				$this->MultiCell(0,4, utf8_decode('SECRETARÍA DE LA CONTRALORÍA
COORDINACIÓN DE ADMINISTRACIÓN
SUBDIRECCIÓN DE ADMINISTRACIÓN DE RECURSOS'),0,'R');
			}
			$this->SetFillColor(150,152,154);
			$this->SetTextColor(255,255,255);
			$this->SetFont(null,null,6);
			$this->Cell(0,4, utf8_decode('AVENIDA PRIMERO DE MAYO #1731, ROBERTH BOSH COL. ZONA INDUSTRIAL C.P. 50071, TOLUCA, ESTADO DE MÉXICO TELÉFONOS : (722) 275 67 00 EXT. 6538'),0,0,'C',true);
			$this->Ln(3);
			$this->Cell(25,4,'www.edomex.gob.mx',0,0,'L',true);
			$this->Cell(0,4, utf8_decode( 'Página '.$page.' de {nb}' ) ,0,0,'C',true); 
			$fecha=date('d/m/Y');
			//$this->Cell(0,4,"Fecha: $fecha",0,0,'R',true);
			$this->SetFont(null,'B',6);
			$this->Cell(0,4,utf8_decode($name),0,0,'R',true);
		}else
		if ($name == 'Solicitud'){			
			$this->SetFillColor(255,255,255);			
			$this->MultiCell(0,4, utf8_decode('
			SECRETARÍA DE FINANZAS
			SUBDIRECCIÓN DE ADMINISTRACIÓN'),0,'R');
			$this->SetFillColor(150,152,154);
			$this->SetTextColor(255,255,255);
			$this->SetFont('Arial',null,9);
			$this->MultiCell(0,5, utf8_decode('URAWA No. 100, COL. IZCALLI IPIEM, TOLUCA, ESTADO DE MÉXICO, C.P. 50150'),0,'C',true);
			$this->MultiCell(0,5, utf8_decode('www.edomex.gob.mx                      Página '.$page.' de {nb}                      '.$name),0,'C',true);
		}
			
	}
	
	public $name;	
	public function setName($name){
		$this->name = $name;
	}
	
	var $angle=0;
	function girar($angle=0,$x=-1,$y=-1){
		if($x==-1)
		$x=$this->x;
		if($y==-1)
		$y=$this->y;
		if($this->angle!=0)
		$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}
	
	//Lineas para definir multicell ajustable
	var $widths;
	function SetWidths($w) 
	{ 
		//Set the array of column widths 
		$this->widths=$w; 
	} 
	
	var $aligns;
	function SetAligns($a) 
	{ 
		//Set the array of column alignments 
		$this->aligns=$a; 
	} 

	function fill($f)
	{
		//juego de arreglos de relleno
		$this->fill=$f;
	}
	
	function head($header){
		$this->SetFont('Arial', 'B', '7' );
		$this->Row($header,1,TRUE);
		$this->SetFont('Arial', null, '7' );
	}

	function Row($data,$line='0',$fill='0',$header='',$ln='5')
	{
		$style=null;
		//Calculate the height of the row 
		$nb=0; 
		for($i=0;$i<count($data);$i++) 
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
		$h=$ln*$nb; 
		//Issue a page break first if needed 
		$res = $this->CheckPageBreak($h);
		if($header and $res){
			$this->head($header);
		}
		//Draw the cells of the row 
		for($i=0;$i<count($data);$i++) 
		{
			$w=$this->widths[$i]; 
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
			//Save the current position 
			$x=$this->GetX(); 
			$y=$this->GetY(); 
			//Draw the border 
			if($line)
				$this->Rect($x,$y,$w,$h,$style); 
			//Print the text 
			$this->MultiCell($w,$ln,utf8_decode($data[$i]),0,$a,$fill);
			//Put the position to the right of the cell 
			$this->SetXY($x+$w,$y); 
		} 
		//Go to the next line 
		$this->Ln($h); 
	}
	
	function CheckPageBreak($h)
	{ 
		//If the height h would cause an overflow, add a new page immediately 
		if($this->GetY()+$h>$this->PageBreakTrigger){
			$this->AddPage($this->CurOrientation,$this->CurPageSize);
			return TRUE;
		}
			return FALSE;
	} 

	function NbLines($w,$txt) 
	{ 
		//Computes the number of lines a MultiCell of width w will take 
		$cw=&$this->CurrentFont['cw']; 
		if($w==0) 
			$w=$this->w-$this->rMargin-$this->x; 
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
		$s=str_replace("\r",'',$txt); 
		$nb=strlen($s); 
		if($nb>0 and $s[$nb-1]=="\n") 
			$nb--; 
		$sep=-1; 
		$i=0; 
		$j=0; 
		$l=0; 
		$nl=1; 
		while($i<$nb) 
		{ 
			$c=$s[$i]; 
			if($c=="\n") 
			{ 
				$i++; 
				$sep=-1; 
				$j=$i; 
				$l=0; 
				$nl++; 
				continue; 
			} 
			if($c==' ') 
				$sep=$i; 
			$l+=$cw[$c]; 
			if($l>$wmax) 
			{ 
				if($sep==-1) 
				{ 
					if($i==$j) 
						$i++; 
				} 
				else 
					$i=$sep+1; 
				$sep=-1; 
				$j=$i; 
				$l=0; 
				$nl++; 
			} 
			else 
				$i++; 
		} 
		return $nl; 
	}
	//Fin Lineas para definir multicell ajustable
	
	var $tablewidths;
	var $tablealigns;
	var $footerset;

	

	function morepagestable($datas, $lineheight=5) {
		// some things to set and 'remember'
		$l = $this->lMargin;
		$startheight = $h = $this->GetY();
		$startpage = $currpage = $maxpage = $this->page;

		// calculate the whole width
		$fullwidth = 0;
		foreach($this->tablewidths AS $width) {
			$fullwidth += $width;
		}

		// Now let's start to write the table
		foreach($datas AS $row => $data) {
			$this->page = $currpage;
			// write the horizontal borders
			$this->Line($l,$h,$fullwidth+$l,$h);
			// write the content and remember the height of the highest col
			foreach($data AS $col => $txt) {
				$this->page = $currpage;
				$this->SetXY($l,$h);
				$this->MultiCell($this->tablewidths[$col],$lineheight,utf8_decode($txt),null,$this->tablealigns[$col]);
				$l += $this->tablewidths[$col];

				if(!isset($tmpheight[$row.'-'.$this->page]))
					$tmpheight[$row.'-'.$this->page] = 0;
				if($tmpheight[$row.'-'.$this->page] < $this->GetY()) {
					$tmpheight[$row.'-'.$this->page] = $this->GetY();
				}
				if($this->page > $maxpage)
					$maxpage = $this->page;
			}

			// get the height we were in the last used page
			$h = $tmpheight[$row.'-'.$maxpage];
			// set the "pointer" to the left margin
			$l = $this->lMargin;
			// set the $currpage to the last page
			$currpage = $maxpage;
		}
		// draw the borders
		// we start adding a horizontal line on the last page
		$this->page = $maxpage;
		$this->Line($l,$h,$fullwidth+$l,$h);
		// now we start at the top of the document and walk down
		for($i = $startpage; $i <= $maxpage; $i++) {
			$this->page = $i;
			$l = $this->lMargin;
			$t  = ($i == $startpage) ? $startheight : $this->tMargin;
			$lh = ($i == $maxpage)   ? $h : $this->h-$this->bMargin;
			$this->Line($l,$t,$l,$lh);
			$this->Line($l,$t,$fullwidth+$l,$t);
			$this->Line($l,$lh,$fullwidth+$l,$lh);
			foreach($this->tablewidths AS $width) {
				$l += $width;
				$this->Line($l,$t,$l,$lh);
			}
		}
		// set it to the last page, if not it'll cause some problems
		$this->page = $maxpage;
		$this->SetY($h);
	}
	
}
