<?php

namespace App\Http\Controllers;

use App\User;
use App\Recibodig;
use App\ClientesExpo;
use Illuminate\Http\Request;


class VentasController extends Controller
{
   public function index(){
       $registros=ClientesExpo::where('status','P')->get();
       $ejecutivos=User::all();
       return view('principal.ventas_capturadas',compact('registros','ejecutivos'));
   }
   public function show($registro){
       $registros=ClientesExpo::where('cid_expedi',$registro)->first();
       $recibos=Recibodig::where('cid_expediente',$registro)->where('cancelado',0)->get();
       $efectivoMXN=Recibodig::where('cid_expediente',$registro)->where('cancelado',0)->where('concepto','EFECTIVO')->where('moneda','MXN')->sum('monto');
       $efectivoMXN=number_format($efectivoMXN,2);
       $efectivoUSD=Recibodig::where('cid_expediente',$registro)->where('cancelado',0)->where('concepto','EFECTIVO')->where('moneda','USD')->sum('monto');
       $efectivoUSD=number_format($efectivoUSD,2);
       $tarjetaMXN=Recibodig::where('cid_expediente',$registro)->where('cancelado',0)->where('concepto','TARJETA BANCARIA')->where('moneda','MXN')->sum('monto');
       $tarjetaMXN=number_format($tarjetaMXN,2);
       $tarjetaUSD=Recibodig::where('cid_expediente',$registro)->where('cancelado',0)->where('concepto','TARJETA BANCARIA')->where('moneda','USD')->sum('monto');
       $tarjetaUSD=number_format($tarjetaUSD,2);
       $MXN=Recibodig::where('cid_expediente',$registro)->where('cancelado',0)->where('moneda','MXN')->sum('monto');
       $MXN=number_format($MXN,2);
       $USD=Recibodig::where('cid_expediente',$registro)->where('cancelado',0)->where('moneda','USD')->sum('monto');
       $USD=number_format($USD,2);
       return view('principal.ventas_detalle',compact('recibos','registros','tarjetaUSD','tarjetaMXN','MXN','USD','efectivoUSD','efectivoMXN'));
   }
}
