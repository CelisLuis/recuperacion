<?php

namespace App\Http\Controllers;

use App\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $habitaciones = new habitacion();
        $datos = $habitaciones::all();
        return view('mostrarHabitaciones', compact('datos'));
    }

    public function indexPrincipal()
    {
        $habitaciones = new habitacion();
        $datos = $habitaciones::all();
        return view('agregarHabitacion', compact('datos'));
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
        $datos = new Habitacion();
        $datos->nombre_habitacion = $request->habitacion;
        $datos->tipo_cama = $request->cama;
        $datos->cantidad_camas = $request->numCamas;
        $datos->cantidad_cuartos = $request->numCuartos;
        $datos->precio_habitacion = $request->precioHabitacion;
        $datos->save();
        return $datos->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function show(Habitacion $habitacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $habitacionEdit = Habitacion::find($id);
        return view('editarHabitacion',compact('habitacionEdit'));
    }

    public function editMantenimiento($id)
    {
        $habitacionMantenimiento = Habitacion::find($id);
        return view('mantenimiento', compact('habitacionMantenimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datos = Habitacion::find($id);
        $datos->cantidad_camas = $request->input('numCamas');
        $datos->cantidad_cuartos = $request->input('numCuartos');
        $datos->precio_habitacion = $request->input('precioHabitacion');
        $datos->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habitacion $habitacion)
    {
        //
    }
}
