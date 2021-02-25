<?php

namespace App\Http\Controllers;

Use DB;
use App\Escenario;
use App\Escenariodet;
use App\Criterio;
use App\Elemento;
use App\Proyecto;
use App\Tema;
// use App\Http\Requests\SaveEscenarioRequest;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class escenarioController extends Controller
{

   function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

      return view('escenarios.index', [
         'escenario' => Escenario::latest()->paginate(8)
      ]);
   }

	public function exportaExcel($id){

        $aElem = DB::Select('SELECT e.cNombre, CONCAT(t.nomcorto,". ",t.descripcion) AS descTema
            FROM escenarios e
            LEFT JOIN temas t ON e.tema_id=t.id
            WHERE e.id='.$id
        );
        $aTit=$aElem[0];
        $sAno = session('glo_periodo');

        $aCrits = DB::select("SELECT CONCAT('C',c.id,'.',c.cnombre) AS crits, ce.npeso,
            (SELECT GROUP_CONCAT(CONCAT(npuntos,' - ', cnombre) SEPARATOR '\n')
                FROM elementos
                WHERE criterio_id = c.id
            ) AS elem
        FROM critero_escenario ce
        LEFT JOIN criterios c ON ce.criterio_id=c.id
        WHERE ce.escenario_id=".$id);

        $aProy = DB::select("SELECT CONCAT(p.cclave,' - ', p.cnombre) AS proyecto,
            IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=1),0) AS C1,
            IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=2),0) AS C2,
            IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=3),0) AS C3,
            IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=4),0) AS C4,
            IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=5),0) AS C5,
            ed.ntotpuntos
        FROM escenariosdet AS ed
           LEFT JOIN proyectos p ON ed.proyecto_id=p.id
        WHERE ed.ntotpuntos>0 AND ed.escenario_id=".$id);

        // $elId = Escenario::findOrfail($id);
        // dd($aCrits);

        ini_set('memory_limit', '-1');
        $nombreReporte = "Formato análisis de alternativas";
		$libro = new Spreadsheet();
        $libro->setActiveSheetIndex(0);
		$libro->getProperties()->setTitle($nombreReporte);
		$libro->getDefaultStyle()->getFont()
			->setName('Calibri')
			->setSize(11);
		$hoja = $libro->getActiveSheet();

		$hoja->setTitle('Reporte Escenario '.$id);

        $style_center = [
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ];

        $style_vcenter = [
          'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ];

        $style_borders1 = [
            'borders' => [
               'outline' => ['style' => Border::BORDER_THIN, 'color' => ['argb' => '000000']],
            ],
        ];

        $style_borders2 = [
            'borders' => [
               'outline' => ['style' => Border::BORDER_MEDIUM, 'color' => ['argb' => '000000']],
            ],
        ];

        // Logo o escudo
        $oImg = new Drawing;
        $oImg->setName('Logo');
        $oImg->setDescription('Logo');
        $oImg->setPath('img/left.png');
        $oImg->setCoordinates('B1');
        // $oImg->setHeight(75);
        $oImg->setOffsetX(40);
        $oImg->setWorksheet($libro->getActiveSheet());

        $cTitle = "Gestión de Proyectos de Obra Pública ".$sAno." - Gobierno Municipal de Guanajuato";
        $hoja->setCellValue('C1',$cTitle);
        // ajustaTexto($hoja,'A1');
        ajustaTexto($hoja, 'C1');
        $hoja->mergeCells('C1:F1');
        formatTitulos($hoja,'C1:F1',14,'Verdana',2);
        $hoja->getRowDimension('1')->setRowHeight(90);

        $aABCD=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS"  );
        $aAncho=array(3,26.5,31,31,31,31);

        for ($i=0; $i<=5; $i++) {
            ajustaAncho($hoja,$aABCD[$i],$aAncho[$i]);
        }

        $iRow=4;
        $hoja->setCellValue('B'.$iRow,'Escenario:');
        formatDatos($hoja,'B'.$iRow,false,2,true,false,'FFB4C6E7');
        $hoja->setCellValue('C'.$iRow,$aTit->cNombre);
        $hoja->mergeCells('C'.$iRow.':F'.$iRow);
        formatDatos($hoja,'C'.$iRow.':F'.$iRow);
        $hoja->getRowDimension($iRow)->setRowHeight(17);
        $iRow+=1;
        $hoja->setCellValue('B'.$iRow,'Tema:');
        formatDatos($hoja,'B'.$iRow,false,2,true,false,'FFB4C6E7');
        $hoja->setCellValue('C'.$iRow,$aTit->descTema);
        $hoja->mergeCells('C'.$iRow.':F'.$iRow);
        formatDatos($hoja,'C'.$iRow.':F'.$iRow);
        $hoja->getRowDimension($iRow)->setRowHeight(17);

        $iRow+=1;
        $hoja->getRowDimension($iRow)->setRowHeight(23);

        $iRow+=1;
        $hoja->setCellValue('B'.$iRow,'CRITERIOS DE PUNTUACIÓN');
        // formatDatos($hoja,'B'.$iRow,false,2,true,false,'FF4472C4');
        formatTitulos($hoja,'B'.$iRow,11,'Calibri',2,'FF4472C4','FFFFFF');
        $hoja->setCellValue('C'.$iRow,'PESO ASIGNADO');
        // formatDatos($hoja,'C'.$iRow,false,2,true,false,'FF4472C4');
        formatTitulos($hoja,'C'.$iRow,11,'Calibri',2,'FF4472C4','FFFFFF');
        $hoja->setCellValue('D'.$iRow,'ELEMENTOS');
        $hoja->getStyle('D'.$iRow)->getFont()->setBold(true);
        $hoja->mergeCells('D'.$iRow.':F'.$iRow);
        formatDatos($hoja,'D'.$iRow.':F'.$iRow,true,2,true,false,'FFB4C6E7');
        $hoja->getRowDimension($iRow)->setRowHeight(24);

        $iRow+=1;
        foreach ($aCrits as $row) {
            // print_r($row->crits);
            $iCol=1;
            foreach ($row as $key => $value) {
                $hoja->setCellValueByColumnAndRow($iCol+1, $iRow, $value);
                switch ($iCol) {
                    case '1':
                        // formatDatos($hoja,$aABCD[$iCol].$iRow,true,2,false);
                        formatTitulos($hoja,$aABCD[$iCol].$iRow,11,'Calibri',2,'FFFFFF','000000',false,false);
                        break;
                    case '2':
                        // formatDatos($hoja,$aABCD[$iCol].$iRow);
                        formatTitulos($hoja,$aABCD[$iCol].$iRow,11,'Calibri',2,'FFFFFF','000000',false);
                        break;
                    case '3':
                        $hoja->mergeCells($aABCD[$iCol].$iRow.':'.$aABCD[$iCol+2].$iRow);
                        formatDatos($hoja,$aABCD[$iCol].$iRow.':'.$aABCD[$iCol+2].$iRow,true,1,false,true);
                        break;
                }
                $iCol+=1;
            }
            $hoja->getRowDimension($iRow)->setRowHeight(43);
            $iRow+=1;
        }
        // dd($aCrits);
        $iRow+=2;
        // Si existen proyectos del escenario seleccionado
        if (count($aProy)>0) {
            $hoja->setCellValue('B'.$iRow,'PROYECTO');
            formatTitulos($hoja,'B'.$iRow,11,'Arial',1,'000000','FFFFFF');
            $iCol=2;
            foreach ($aCrits as $row) {
                $hoja->setCellValueByColumnAndRow($iCol+1, $iRow, 'PUNTOS '.substr($row->crits,0,2));
                formatTitulos($hoja,$aABCD[$iCol].$iRow,11,'Arial',1,'000000','FFFFFF');
                $iCol+=1;
            }
            $hoja->setCellValue('F'.$iRow, 'PUNTUACIÓN TOTAL');
            formatTitulos($hoja,'F'.$iRow,11,'Arial',1,'000000','FFFFFF');
            $hoja->getRowDimension($iRow)->setRowHeight(18);
            $iRow+=1;
            foreach ($aProy as $row) {
                $iCol=1;
                foreach ($row as $key => $value) {
                    if ($iCol>1 && $value>0) {
                        $hoja->setCellValueByColumnAndRow($iCol+1, $iRow, $value,DataType::TYPE_NUMERIC);
                        formatDatos($hoja,$aABCD[$iCol].$iRow,false,1);
                        $iCol+=1;
                    }elseif($iCol==1){
                        $hoja->setCellValueByColumnAndRow($iCol+1, $iRow, $value);
                        formatDatos($hoja,$aABCD[$iCol].$iRow,false,1,false);
                        $hoja->getStyle($aABCD[$iCol].$iRow)->getFont()->setBold(true);
                        $hoja->getStyle($aABCD[$iCol].$iRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                        $hoja->getStyle($aABCD[$iCol].$iRow)->getAlignment()->setWrapText(true);
                        $iCol+=1;
                    }
                }
                $hoja->getRowDimension($iRow)->setRowHeight(33);
                $iRow+=1;
            }
        }


		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="'.$this->data["exlstitle"].'.xlsx"');
		header('Content-Disposition: attachment;filename="'.$nombreReporte.'.xlsx"');
		header('Cache-Control: max-age=0');
        // header('Cache-Control: max-age=1');
        // header('Cache-Control: cache, must-revalidate');
        // header('Pragma: public');
		$oWriter = IOFactory::createWriter($libro, 'Xlsx');
        // $oWriter = new Xlsx($libro);

		// ob_end_clean();

		$oWriter->save('php://output');
        die;
	}


   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
		// $criteriosTodos = Criterio::pluck('cnombre','id');
		$criteriosTodos = Criterio::all();
		$elementos = Elemento::all();
		$proyectos = Proyecto::all();
		$temas = Tema::pluck('nomcorto','id')->toArray();

		return view('escenarios.create', [
		'escenario' => new Escenario,
		'criteriosTodos' => $criteriosTodos,
		'elementos' => $elementos,
		'temas' => $temas,
		'proyectos' => $proyectos
		]);

       // return view('escenarios.create', [
       //    'escenario' => new Escenario
       // ]);
   }

   public function getProyectos(Request $request){

      // $query = Proyecto::select('cclave','cnombre','ncosto','nduracion','unidades_rh')
      //    ->with('criteriosxproy')
      //    ->get();
      // $query = Proyecto::latest()->with('criteriosxproy')->get();
      // $query = Proyecto::with('criteriosxproy')->get();
      $query = DB::select(DB::raw('CALL sp_critxproy'));

      // return $query;

     //  $query = DB::table('escenarios as e')
     //     ->join('escenariosdet as ed', 'e.id', 'ed.escenario_id')
     //     ->join('proyectos as p', 'ed.proyecto_id', 'p.id')
     //     ->joinSub($result, 'result', function($join){
     //        $join->on('ed.proyecto_id','=','result.id');
     //     })
     //     ->select('e.cnombre AS escenario', DB::raw('CONCAT(p.cclave," - ",p.cnombre) AS proyecto'), 'ed.ntotpuntos', 'ed.ncosto', 'ed.unidades_rh', 'ed.excluir')
     //     ->where('e.id', '1')
     //     ->get();

     // return $query;

		if ($request->ajax()) {
			return Datatables()
			->of($query)
			->make(true);
		}

   }

   public function getProy_easy(){

      // $query = DB::select(DB::raw('CALL sp_critxproy'));

      // return $query;
      $criteriosTodos = Criterio::all();

      return view('escenarios.getProy_easy', compact('criteriosTodos'));
   }


   public function respondCreated($message)
   {
     //if you to return message to view or ajax process
     return response()->json(['message'=>$message]);
     //Pass message parameter as message  for ajax
     //or anything with message
   }


   // public function proy_para_escenarios(Request $request){
   //    $query = DB::select(DB::raw('CALL sp_critxproy'));
   //    return $query;
   // }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {

      // $ncrits = count(Request()->aCrits);
      // dd($request->json()->all());
      $data = json_decode($request->getContent(), true);
      // if (json_last_error() != JSON_ERROR_NONE) {
      //    return response()->json("JSON Error: %s", json_last_error_msg(), 450);
      // }
      $rules = [
         'cnombre' => 'required',
         'tema_id' => 'required',
         'ntotcosto' => 'nullable',
         'ntotrh' => 'nullable'
      ];

      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
         return response()->json($validator->messages(), 450);
         // return back()->with('error', $validator->messages()->all()[0])->withInput();
         // return response()->json(['errors'=>$validator->errors()]);
      }

      $validaok = true;
      DB::beginTransaction();
      try {
         $escenario = new Escenario;
         $escenario->cnombre = $data['cnombre'];
         $escenario->tema_id = $data['tema_id'];
         $escenario->ntotcosto = $data['ntotcosto'];
         $escenario->ntotrh = $data['ntotrh'];
         $maxId = DB::table('escenarios')->max('id');
         $escenario->save();
         $escid = $escenario->id;
         $escOk = ($escid > 0);
// dd($escid);
         $criterios = $data['aCrits'];
         $critOk = !empty($criterios);

         // $criterios = array_filter($criterios, function($v){
         //    return $v != 0;
         // });
         $pesos = $data['aPeso'];
         $pesoOk = !empty($pesos);
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($pesos[$criterio] > 0) {
               $escenario->criteriosxescenario()->attach($criterios[$criterio], ['npeso' => $pesos[$criterio]]);
            }
         }
         $datosGrid = $data['grid'];
// dd($datosGrid);
         foreach ($datosGrid as &$valor) {
            // $valor = get_object_vars($valor);
            $escDetId = DB::table('escenariosdet')->insertGetId([
               'escenario_id' => $escid,
               'proyecto_id'  => $valor['id'],
               'ntotpuntos'   => $valor['ntotpuntos'],
               'excluir'      => $valor['excluir'],
               'created_at'   => now(),
               'updated_at'   => now(),
            ]);
            // Inserto el detalle de escenariosdet por criterio para registrar los puntos capturados
            for ($crit=0; $crit < count($criterios); $crit++) {
               $cr = $criterios[$crit];
               $pCrit = "C".$cr;
               DB::table('criterio_escenariodet')->insertOrIgnore([
                  'escenariodet_id' => $escDetId,
                  'criterio_id'     => $cr,
                  'npuntos'         => $valor[$pCrit],
                  'created_at'      => now(),
                  'updated_at'      => now(),
               ]);
            }
         }
// dd("Termina la inserción de datos");
         if (!$escOk || !$critOk || !$pesoOk) {
            throw new Exception;
            // return response()->json("Favor de seleccionar criterios y peso de criterios", 450);
            // return $this->respondCreated([0,'Favor de seleccionar criterios y peso de criterios']);
         }
         // else {
         //    DB::commit();
         //    return $this->respondCreated([1,'El escenario fue creado con éxito']);
         // }
      }catch(\Exception $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Hay una excepción en el controlador'];
         return response()->json($err, 450);
         // throw new Exception("Favor de seleccionar criterios y peso de criterios", 1);
      }catch (\Throwable $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Falta completar información'];
         return response()->json($err, 450);
      }
// dd("No hay errores después catch");
      DB::commit();
      return $this->respondCreated([1,'El escenario fue creado con éxito']);

      // return response()->json(["respuesta" => 1]);
      // return redirect()->route('escenarios.index')->with('success', 'El escenario fue creado con éxito');

      // if ( $request->has('aCrits') ) {
      //    $res = Elemento::whereIn('id',$request->elementos)
      //       ->update(['criterio_id' => $resul->id]);
      // }


   }

      // return response()->json(['message'=>'Tu información ha sido recibida'],200);
   /**
    * Display the specified resource.
    *
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function show(Escenario $escenario)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function edit(Escenario $escenario)
   {
       $criteriosTodos = Criterio::all();
       $elementos = Elemento::all();
       $proyectos = Proyecto::all();
       $temas = Tema::pluck('nomcorto','id')->toArray();
       $escenario->with('criteriosxescenario','tema','proyectosyescenarios');
       // dd($escenario->criteriosxescenario->pluck('npeso','id')->toArray());
       $aCritPesos=[];
       foreach ($escenario->criteriosxescenario as $dato) {
         $aCritPesos[] = ["cid" => $dato->id, "peso" => $dato->pivot->npeso];
       }
       // $res = is_numeric(array_search(1, array_column($aCritPesos, 'cid')));
       // dd($res);
       // dd($escenario->proyectosyescenarios);
       $aDetalles = [];
       foreach ($escenario->proyectosyescenarios as $dato) {
         $aDetalles[] = ["proy_id" => $dato->id, "cnombre" => $dato->cnombre];
       }
       // dd($aCritPesos);
       // dd($escenario->tema->id);

       return view('escenarios.edit', [
         'escenario' => $escenario,
         'criteriosTodos' => $criteriosTodos,
         'acritpesos' => $aCritPesos,
         'elementos' => $elementos,
         'temas' => $temas,
         'proyectos' => $proyectos
       ]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Escenario $escenario, $id)
   {

      // dd($request->all());
      // dd("Llega al controller");
      $data = json_decode($request->getContent(), true);
      // return $data['cnombre'];

      DB::beginTransaction();
      try{

         // $escenario->update($request->all());
         $escenario = $escenario->find($id);
         DB::table('escenarios')
            ->where('id',$id)->update([
               'cnombre' => $data['cnombre'],
               'ntotcosto' => $data['ntotcosto'],
               'ntotrh'    => $data['ntotrh']
         ]);

         $criterios = $data['aCrits'];
         $critOk = !empty($criterios);
         // $criterios = array_filter($criterios, function($v){
         //    return $v != 0;
         // });
         $pesos = $data['aPeso'];
         $pesoOk = !empty($pesos);
         $escenario->criteriosxescenario()->detach();
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($pesos[$criterio] > 0) {
               $escenario->criteriosxescenario()->attach($criterios[$criterio], ['npeso' => $pesos[$criterio]]);
            }
         }

         $datosGrid = $data['grid'];

         $escid = $escenario->id;

         foreach ($datosGrid as &$valor) {
            // $valor = get_object_vars($valor);
            DB::table('escenariosdet')->updateOrInsert(
                  ['escenario_id' => $escid, 'proyecto_id' => $valor['proy_id']],
                  [
                     'ntotpuntos'   => $valor['ntotpuntos'],
                     'excluir'      => $valor['excluir'],
                     'updated_at'   => now(),
                  ]
            );
            $escDetId = $valor['id'];
            // Atualizo en detalle de escenariosdet por criterio para registrar los puntos capturados
            for ($crit=0; $crit < count($criterios); $crit++) {
               $cr = $criterios[$crit];
               $pCrit = "C".$cr;
               DB::table('criterio_escenariodet')->updateOrInsert(
                  ['escenariodet_id' => $escDetId, 'criterio_id' => $cr],
                  [
                     'npuntos'      => $valor[$pCrit],
                     'created_at'   => now(),
                     'updated_at'   => now(),
                  ]
               );
            }
         }
         if (!$critOk || !$pesoOk) {
            throw new Exception;
            // return response()->json("Favor de seleccionar criterios y peso de criterios", 450);
            // return $this->respondCreated([0,'Favor de seleccionar criterios y peso de criterios']);
         }
      }catch(\Exception $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Hay una excepción en el controlador'];
         return response()->json($err, 450);
         // throw new Exception("Favor de seleccionar criterios y peso de criterios", 1);
      }catch (\Throwable $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Falta completar información'];
         return response()->json($err, 450);
      }

      DB::commit();

      return $this->respondCreated([1,'El escenario fue actualizado con éxito']);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {

      if(Escenario::findOrfail($id)->delete()){
         return redirect()->route('escenarios.index')->with('success', 'El escenario fue eliminado con éxito');
      }else{
         return response()->json([
            'mensaje' => 'Error al eliminar el escenario !'
         ]);
      }
   }
}
