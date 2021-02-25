<?php
// Creo funciones personalizadas

use App\Periodo;
use App\Proyecto;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

function h_topes (){

   $pactivo = Periodo::select('ntope_costo','ntope_rh')
    ->where('activo','1')->first();

   $topes = isset($pactivo) ? [$pactivo->ntope_costo,$pactivo->ntope_rh] : [];

   return $topes;

}

function h_totales_escenario (){

   $total = [ Proyecto::sum('ncosto'), Proyecto::sum('unidades_rh') ];

   return $total;
}

// Funciones para utilizar con PhpSpreadSheet
function ajustaTexto($oExcel,$cell){
    $oExcel->getStyle($cell)->getAlignment()->setWrapText(true);
}

function ajustaAncho($oExcel,$cell,$ancho){
    $oExcel->getColumnDimension($cell)->setWidth($ancho);
  }

function formatTitulos($oExcel,$cells,$pppFuente,$cFuente='Arial',$bordes=0,$colorFdo='FFFFFF',$colorFont='000000',$ajusta=true,$centrah=true){
    $tipoBorde=$bordes==1 ? Border::BORDER_THIN : ($bordes==2 ? Border::BORDER_MEDIUM : Border::BORDER_NONE);
    $centrah=$centrah ? Alignment::HORIZONTAL_CENTER : '';
    $oExcel->getStyle($cells)->applyFromArray([
        'borders' => [
            'outline' => ['borderStyle' => $tipoBorde, 'color' => ['argb' => '000000']],
        ],
        'font' => [
            'color' => ['rgb' => $colorFont],
            'size'  => $pppFuente,
            'bold'  => true,
            'name'  => $cFuente
        ],
        'alignment' => [
            'horizontal' => $centrah,
            'vertical'   => Alignment::VERTICAL_CENTER,
            'wrap'       => $ajusta
        ],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $colorFdo]],
    ]);
}

function formatDatos($oExcel,$cells,$ajusta=true,$bordes=1,$centrah=true,$justifica=false,$colorFdo='FFFFFF'){
    $tipoBorde=$bordes==1 ? Border::BORDER_THIN : ($bordes==2 ? Border::BORDER_MEDIUM : Border::BORDER_NONE);
    $alinea=$centrah ? Alignment::HORIZONTAL_CENTER : ($justifica ? Alignment::HORIZONTAL_JUSTIFY : '');
    $oExcel->getStyle($cells)->applyFromArray(
      [ 'borders' => [
          'outline' => ['borderStyle' => $tipoBorde, 'color' => ['argb' => '000000']],
        ],
        'alignment' => [
          'horizontal' => $alinea,
          'vertical'   => Alignment::VERTICAL_CENTER,
          'wrap'       => $ajusta
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => $colorFdo],
        ],
      ]
    );
}


function formatBorde($oExcel,$cells,$bordes=1,$color='000000'){
    $tipoBorde=$bordes==1 ? Border::BORDER_THIN : ($bordes==2 ? Border::BORDER_MEDIUM : Border::BORDER_NONE);
    $oExcel->getStyle($cells)->applyFromArray(
      [ 'borders' => [
          'outline' => ['borderStyle' => $tipoBorde, 'color' => ['argb' => $color]],
        ],
      ]
    );
}

?>
