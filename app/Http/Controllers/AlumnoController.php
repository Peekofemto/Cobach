<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use Maatwebsite\Excel\Facades\Excel;
class AlumnoController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar=='') {
            //Creando un array de tipo Alumno(model)
            $alumnos = Alumno::orderBy('id', 'desc')->paginate(20);
        }
        else {
            $alumnos = Alumno::where($criterio, 'like', '%' . $buscar . '%' )->orderBy('id', 'desc')->paginate(20);
        }

        return[
            'pagination' => [
                'total'        => $alumnos->total(),
                'current_page' => $alumnos->currentPage(),
                'per_page'     => $alumnos->perPage(),
                'last_page'    => $alumnos->lastPage(),
                'from'         => $alumnos->firstItem(),
                'to'           => $alumnos->lastItem(),
            ],
            'alumnos' => $alumnos
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        if(!$request->ajax()) return redirect('/');
        //Creando un objeto de tipo categoria(model)
        $alumno = new Alumno();
        $alumno->numero_control = $request->numero_control;
        $alumno->nombre = $request->nombre;
        $alumno->email = $request->email;
        $alumno->condicion = '1';
        $alumno->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        if(!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->numero_control = $request->numero_control;
        $alumno->nombre = $request->nombre;
        $alumno->email = $request->email;
        $alumno->condicion = '1';
        $alumno->save();
    }

    public function desactivar(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        if(!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion = '0';
        $alumno->save();
    }

    public function activar(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        if(!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion = '1';
        $alumno->save();
    }

    public function import(Request $request){
        \Excel::load($request->excel, function($reader) {
 
            $excel = $reader->get();
     
            // iteracción
            $reader->each(function($row) {
     
                $alumno = new Alumno;
                $alumno->numero_control = $row->numero_control;
                $alumno->nombre = $row->nombre;
                $alumno->email = $row->email;
                $alumno->condicion = '1';
                $alumno->save();
     
            });
        
        });
     
        return back();
    }
}
