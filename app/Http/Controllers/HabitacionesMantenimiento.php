<?php

namespace App\Http\Controllers;

use App\HabitacionMantenimiento;
use Illuminate\Http\Request;

class HabitacionesMantenimiento extends Controller
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
        return view('mantenimiento');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HabitacionMantenimiento  $habitacionMantenimiento
     * @return \Illuminate\Http\Response
     */
    public function show(HabitacionMantenimiento $habitacionMantenimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HabitacionMantenimiento  $habitacionMantenimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(HabitacionMantenimiento $habitacionMantenimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HabitacionMantenimiento  $habitacionMantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HabitacionMantenimiento $habitacionMantenimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HabitacionMantenimiento  $habitacionMantenimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(HabitacionMantenimiento $habitacionMantenimiento)
    {
        //
    }
}
