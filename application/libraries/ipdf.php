<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'assets\\fpdf\\fpdf.php';	
require_once 'assets\\fpdi\\fpdi.php';	

class ipdf extends FPDI
{
	public function __construct() {
		parent::__construct();
	}

	public function integrar($archivo='',$ruta=''){
		
		if($archivo){
			$orientacion = 'P';
			$tamaño = 'Letter';
			
			$this->setSourceFile($archivo);
			$pageCount = $this->setSourceFile($archivo);
			
			if($pageCount<3)
				return false;

			$x=1;
			$y=2;
			$z=3;
			
			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo=$pageNo+3) {
						
					// add a page
					$this->AddPage($orientacion,$tamaño);
					$tplIdx = $this->importPage($x);
					$this->useTemplate($tplIdx, 1, 1,216);
					
					$this->AddPage($orientacion,$tamaño);
					$tplIdx = $this->importPage($y);
					$this->useTemplate($tplIdx, 1, 1,216);
					
					$this->AddPage($orientacion,$tamaño);
					$tplIdx = $this->importPage($z);
					$this->useTemplate($tplIdx, 1, 1,216);
					
					$this->image('assets/img/sello_png.png',87,205,35);
					$this->image('assets/img/firma_png.png',20,207,45);
					
					$x=$x+3;
					$y=$y+3;
					$z=$z+3;
					
					
			}
			
			if($ruta)
				$archivo = $ruta.'/'.@end(explode("/", $archivo)); 
			
			$this->Output($archivo,'F');
			return true;
		}
		return false;
	}

}