<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //Creando un array de tipo Alumno(model)
      $alumnos = Alumno::all();
      return $alumnos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $alumno = new Alumno();
      $alumno->nombre = $request->nombre;
      $alumno->semestre = $request->semestre;
      $alumno->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $alumno = Alumno::findOrFail($request->id);
        $alumno->nombre = $request->nombre;
        $alumno->semestre = $request->semestre;
        $alumno->save();
    }

}
