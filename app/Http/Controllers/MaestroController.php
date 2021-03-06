<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maestro;

class MaestroController extends Controller
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
            //Creando un array de tipo Maestro(model)
            $maestros = Maestro::orderBy('id', 'desc')->paginate(4);
        }
        else {
            $maestros = Maestro::where($criterio, 'like', '%' . $buscar . '%' )->orderBy('id', 'desc')->paginate(4);
        }

        return[
            'pagination' => [
                'total'        => $maestros->total(),
                'current_page' => $maestros->currentPage(),
                'per_page'     => $maestros->perPage(),
                'last_page'    => $maestros->lastPage(),
                'from'         => $maestros->firstItem(),
                'to'           => $maestros->lastItem(),
            ],
            'maestros' => $maestros
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
        $maestro = new Maestro();
        $maestro->numero_control = $request->numero_control;
        $maestro->nombre = $request->nombre;
        $maestro->email = $request->email;
        $maestro->condicion = '1';
        $maestro->save();
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
        $maestro = Maestro::findOrFail($request->id);
        $maestro->numero_control = $request->numero_control;
        $maestro->nombre = $request->nombre;
        $maestro->email = $request->email;
        $maestro->condicion = '1';
        $maestro->save();
    }

    public function desactivar(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        if(!$request->ajax()) return redirect('/');
        $maestro = Maestro::findOrFail($request->id);
        $maestro->condicion = '0';
        $maestro->save();
    }

    public function activar(Request $request)
    {
        //Si no es un request de ajax no hacemos nada por seguridad
        if(!$request->ajax()) return redirect('/');
        $maestro = Maestro::findOrFail($request->id);
        $maestro->condicion = '1';
        $maestro->save();
    }
}
