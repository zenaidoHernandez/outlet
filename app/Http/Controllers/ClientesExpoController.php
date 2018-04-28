<?php

namespace App\Http\Controllers;

use App\ClientesExpo;
use Illuminate\Http\Request;

class ClientesExpoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = ClientesExpo::all();

        return view('principal.registros_capturados',compact('$registros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = new \DateTime();
        $fecha=$now->format('Y-n-d');
        return view('principal.captura_datos', compact('fecha'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = $request->all();
        $datos['folexpo'] = "0001";
        $datos['fechahora'] = "2017-05-11 10:18:56";
        $datos['hora'] = "10:18:56";
        $datos['fecha'] = "2017-05-11";
        $datos['ftc'] = "2017-05-11";
        $datos['nid_depto'] = "2";
        $datos['nid_area'] = "1";
        $datos['ftc'] = "2017-05-11";
        $datos['tc'] = "18.90";
        $datos['status'] = "x";
        $datos['cid_emplea'] = "1";
        $datos['ciniciales'] = "mx";
        $datos['nvendedor'] = "nombre del vendedor";
        $datos['mailejec'] = "email ejecutivo";

        $cliente = ClientesExpo::create($datos);

        return "nuevo cliente registrado";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientesExpo  $clientesExpo
     * @return \Illuminate\Http\Response
     */
    public function show(ClientesExpo $clientesExpo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientesExpo  $clientesExpo
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientesExpo $clientesExpo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientesExpo  $clientesExpo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientesExpo $clientesExpo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientesExpo  $clientesExpo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientesExpo $clientesExpo)
    {
        //
    }
}
