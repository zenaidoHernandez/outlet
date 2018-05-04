<?php

namespace App\Http\Controllers;

use App\Tnumeracion;
use App\ClientesExpo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpedienteController extends Controller
{
    function generaExpediente(Request $request)
    {
	$cliente = ClientesExpo::where('folexpo',$request->folExpo)->first();
		
	$folexpo 	= trim($cliente->folexpo);
	$cnombre 	= strtoupper(trim($cliente->cnombre));
	$capellidop = strtoupper(trim($cliente->capellidop));
	$capellidom = strtoupper(trim($cliente->capellidom));
	$lada 		= trim($cliente->clada);
	
	$telefono 	= trim($cliente->ctelefono);
	$cext 		= trim($cliente->cext);
	$tipotel 	= trim($cliente->ctipotel);
	$cmail 		= trim($cliente->cmail);
	$cid_destin = trim($cliente->cid_destin);
	$destino 	= trim($cliente->destino);

	$totalpaq 	= trim($cliente->totpaquete);
	$moneda		= trim($cliente->moneda);
	$nid_depto	= trim($cliente->nid_depto);
	$depto 		= trim($cliente->nid_depto);
	$fsalida 	= trim($cliente->fsalida);
	$pax 		= trim($cliente->numpax);
	$iniciales 	= trim($cliente->ciniciales);
	$ejecutivo 	= trim($cliente->nvendedor);
	$cid_emplea = trim($cliente->cid_emplea);
	$expediente = trim($cliente->cid_expedi);
	$observa 	= trim($cliente->observa);
	$tc 		= trim($cliente->tc);
	$impteapag 	= trim($cliente->impteapag);
	$monedap 	= trim($cliente->monedap);
	$letras 	= trim($cliente->letras);
	$dfecha 	= date('Y-m-d');
	$chora 		= date('H:i:s');
	$f_modif 	= date('Y-m-d H:i:s');


	$cid_cliente= $this->numeracion('CLIENTE');

	$cid_funcion= $this->numeracion('FUNCIONARIO');
	if($cliente->cid_expedi == ''){
		$expediente = $this->numeracion('EXPEDIENTE');
	}
	
	DB::table('expediente')->insert(
		[
			'folexpo' => $folexpo, 
			'cid_expediente' => $expediente,
			'dfecha' => $dfecha,
			'chora' => $chora,
			'identificador' => 'OUT',
			'importe' => $totalpaq,
			'comvtas' => 2.00,
			'estatus' => 1,
			'moneda' => $moneda,
			'cid_cliente' => $cid_cliente,
			'iva' =>$totalpaq,
			'tipopaq' =>'S',
			'f_modif' => $f_modif,
			'totpaq' => $totalpaq,
			'minapagar' => $totalpaq,
			'fecha_apertura' => $dfecha,
			'numempleado' => $cid_emplea ,
			'dfechasalida' => $fsalida,
			'pax' => $pax,
			'inicempleado' => $iniciales,
			'nomempleado' => $ejecutivo
		]
	);

	
	#CLIENTE		
		DB::table('tclientes')->insert(
			[
				'cid_cliente' => $cid_cliente,
				'ctipocliente' => 'D',
				'cnombre' => $cnombre,
				'capellidop' => $capellidop,
				'capellidom' => $capellidom,
				'clada' => $lada,
				'ctelefono' => $telefono,
				'cext' => $cext,
				'ctipotelefono' => $tipotel,
				'cmail' => $cmail
			]
		);

	#FUNCIONARIO

	DB::table('tfuncionario')->insert(
		[
			'cid_funcionario' => $cid_funcion,
			'cnombre' => $cnombre,
			'capellidop' => $capellidop,
			'capellidom' => $capellidom,
			'cid_cliente' => $cid_cliente,
			'cmailfunc' => $cmail,
			'cladaf' => $lada,
			'ctelefonof' => $telefono,
			'cextf' => $cext,
			'ctipotelefonof' => $tipotel
		]
	);

	#PASAJERO

	DB::table('pasajeros')->insert(
		[
			'apellidop' => $capellidop,
			'apellidom' => $capellidom,
			'nombre' => $cnombre,
			'titulo' => 'MR',
			'principal' => 1,
			'cid_expediente' => $expediente
		]
	);

	#CONFIRMACIÓN

	DB::table('confirmacion')->insert(
		[
			'cid_client' => $cid_cliente,
			'cid_emplea' => $cid_emplea,
			'cid_destpa' => $cid_destin,
			'dfechahora' => $f_modif,
			'dfechasal' => $fsalida,
			'moneda' => $moneda,
			'totpaq' => $totalpaq,
			'minpag' => $totalpaq,
			'tipopaq' => 'S',
			'f_modif' => $f_modif,
			'cid_expediente' => $expediente,
			'mail' => $cmail,
			'consec' => '1'
		]
	);


	DB::table('expo_mov')
		->where('folexpo', $folexpo)
		->update(
			['cid_expedi' => $expediente, 'status' => 'P', 'tproceso' => $dfecha]
	);

		echo 'HECHO';
	}
	
	function numeracion($concepto){
		$numeracion	= Tnumeracion::where('cconcepto', $concepto)->first();

		$ultimoNumero	= trim($numeracion->nnumero) + 1;
		$_letra			= trim($numeracion->calfabeto);
		Tnumeracion::where('cconcepto',$concepto)
					->update(['nnumero' => $ultimoNumero]);


		if($concepto == 'EXPEDIENTE'){
			$respuesta = 'OUT18'.str_pad($ultimoNumero, 5, "0", STR_PAD_LEFT);
		}

		if($concepto == 'RECIBO'){
			$respuesta = 'EXP18'.str_pad($ultimoNumero, 4, "0", STR_PAD_LEFT);
		}

		if($concepto == 'SOLICITUD'){
			$respuesta = 'SCE8'.str_pad($ultimoNumero, 5, "0", STR_PAD_LEFT);
		}

		if($concepto == 'CLIENTE'){
			$respuesta = 'MCE8'.str_pad($ultimoNumero, 3, "0", STR_PAD_LEFT);
		}

		if($concepto == 'FUNCIONARIO'){
			$respuesta = 'FNE8'.str_pad($ultimoNumero, 3, "0", STR_PAD_LEFT);
		}

		if($concepto == 'FOLIO'){
			$respuesta = str_pad($ultimoNumero, 4, "0", STR_PAD_LEFT);
		}

		return $respuesta;
	}
}