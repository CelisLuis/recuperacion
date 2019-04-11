<?php

namespace App\Http\Controllers;

use App\Reserva;
use App\Habitacion;
use Illuminate\Http\Request;
use DB;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function indexPrincipal()
    {
        $reservas = new Reserva();
        $datos = $reservas::all();
        return view('nuevaReserva', compact('datos'));
    }

    public function mostrarHabitaciones($id)
    {
        $habitacion = Habitacion::find($id);
        return response()->json($habitacion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = new Reserva();
        $datos->id_habitacion = $request->id_habitacion;
        $datos->nombre_cliente = $request->nombre_cliente;
        $datos->apellido_cliente = $request->apellido_cliente;
        $datos->fecha_nacimiento = $request->fecha_nacimiento;
        $datos->inicio_reserva = $request->inicio_reserva;
        $datos->fin_reserva = $request->fin_reserva;
        $datos->costo = $request->totalPagar;
        $datos->save();
        return $datos->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva)
    {
        //
    }
}
