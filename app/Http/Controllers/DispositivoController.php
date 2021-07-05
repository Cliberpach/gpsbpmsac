<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use App\Opcionalerta;
use App\Dispositivo;
use App\TipoDispositivo;
use App\UbicacionRecorrido;
use Illuminate\Support\Facades\Auth;
use GeometryLibrary\SphericalUtil;
use Yajra\Datatables\Datatables;
use App\User;
use Illuminate\Support\Facades\Log;

class DispositivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dispositivo.index');
    }
    public function getTable()
    {
        // return datatables()->query(DB::table('dispositivo')->select('*')->where('dispositivo.estado','ACTIVO')->orderBy('dispositivo.id', 'desc')    )->toJson();
        $data = DB::table('dispositivo')->select('*')->where('dispositivo.estado', 'ACTIVO')->orderBy('dispositivo.id', 'desc')->get();
        return Datatables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('dispositivo.store');
        $dispositivo = new Dispositivo();
        return view('dispositivo.create')->with(compact('action', 'dispositivo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $rules = [
            'nombre' => 'required',
            'nrotelefono' => 'required',
            'operador' => 'required',
            'color' => 'required',
            'cliente' => 'required',
            'pago' => 'required',
            'activo' => 'required',
            'modelo' => 'required',
            'imei' => 'required',
            'marca' => 'required',

        ];
        $message = [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nrotelefono.required' => 'El campo telfono es obligatorio',
            'operador.required' => 'El campo  operador es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'cliente.required' => 'El campo cliente es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'imei.required' => 'El campo imei es obligatorio',
            'marca.required' => 'El campo marca es obligatorio',
            'pago.required' => 'El campo pago es Obligatorio',
            'activo.required' => 'El campo activo es Obligatorio',


        ];

        Validator::make($data, $rules, $message)->validate();

        $dispositivo = new Dispositivo();
        $tipo = TipoDispositivo::FindOrFail($request->nombre);
        $dispositivo->nombre = $tipo->nombre;
        $dispositivo->tipodispositivo_id = $request->nombre;
        $dispositivo->imei = $request->imei;
        $dispositivo->nrotelefono = $request->nrotelefono;
        $dispositivo->operador = $request->operador;
        $dispositivo->cliente_id =$request->cliente;
        $dispositivo->placa = $request->placa;
        $dispositivo->color = $request->color;
        $dispositivo->modelo = $request->modelo;
        $dispositivo->marca = $request->marca;

        $dispositivo->pago = $request->pago;
        $dispositivo->activo = $request->activo;

        $dispositivo->save();
        if ($request->alerta_tabla != "[]" && $request->alerta_tabla != "") {

            $var = json_decode($request->alerta_tabla);
            for ($i = 0; $i < count($var); $i++) {
                Opcionalerta::create([
                    'dispositivo_id' => $dispositivo->id,
                    'alerta_id' => $var[$i]->alerta_id,
                ]);
            }
        }

        //Registro de actividad

        Session::flash('success', 'Dispositivo creado.');
        return redirect()->route('dispositivo.index')->with('guardar', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);

        $put = True;
        $action = route('dispositivo.update', $id);
        $detalle_alerta = DB::table('opcionalerta')
            ->join('alertas as a', 'a.id', '=', 'opcionalerta.alerta_id')
            ->select('opcionalerta.alerta_id', 'a.alerta')
            ->where('dispositivo_id', $id)->get();

        return view('dispositivo.edit', [
            'dispositivo' => $dispositivo,
            'action' => $action,
            'put' => $put,
            'detalle_alerta' => json_encode($detalle_alerta),
        ]);
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
        $data = $request->all();

        $rules = [
            'nombre' => 'required',
            'nrotelefono' => 'required',
            'operador' => 'required',
            'color' => 'required',
            'cliente' => 'required',
            'pago' => 'required',
            'activo' => 'required',
            'modelo' => 'required',
            'imei' => 'required',
            'marca' => 'required',

        ];
        $message = [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nrotelefono.required' => 'El campo telfono es obligatorio',
            'operador.required' => 'El campo  operador es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'cliente.required' => 'El campo cliente es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'imei.required' => 'El campo imei es obligatorio',
            'marca.required' => 'El campo marca es obligatorio',
            'pago.required' => 'El campo pago es Obligatorio',
            'activo.required' => 'El campo activo es Obligatorio',


        ];

        Validator::make($data, $rules, $message)->validate();

        $dispositivo = Dispositivo::FindOrFail($id);
        $tipo = TipoDispositivo::FindOrFail($request->nombre);
        $dispositivo->nombre = $tipo->nombre;
        $dispositivo->tipodispositivo_id = $request->nombre;
        $dispositivo->imei = $request->imei;
        $dispositivo->nrotelefono = $request->nrotelefono;
        $dispositivo->operador = $request->operador;
        $dispositivo->cliente_id =$request->cliente;
        $dispositivo->placa = $request->placa;
        $dispositivo->color = $request->color;
        $dispositivo->modelo = $request->modelo;
        $dispositivo->marca = $request->marca;

        $dispositivo->pago = $request->pago;
        $dispositivo->activo = $request->activo;

        $dispositivo->update();

        if ($request->alerta_tabla != "[]" && $request->alerta_tabla != "") {
            Opcionalerta::where('dispositivo_id', $dispositivo->id)->delete();
            $var = json_decode($request->alerta_tabla);
            for ($i = 0; $i < count($var); $i++) {
                Opcionalerta::create([
                    'dispositivo_id' => $dispositivo->id,
                    'alerta_id' => $var[$i]->alerta_id,
                ]);
            }
        }

        //Registro de actividad

        Session::flash('success', 'Dispositivo modificado.');
        return redirect()->route('dispositivo.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $dispositivo->estado = 'ANULADO';
        $dispositivo->update();

        //Registro de actividad


        Session::flash('success', 'Dispositivo eliminado.');
        return redirect()->route('dispositivo.index')->with('eliminar', 'success');
    }
    public function getvalores(Request $request)
    {

        $existeplaca = false;
        $existeimei = false;
        if (DB::table('dispositivo')->where('placa', $request->placa)->where('id', '!=', $request->id)->where('estado', 'ACTIVO')->count() != 0) {
            $existeplaca = true;
        } else if (DB::table('dispositivo')->where('imei', $request->imei)->where('id', '!=', $request->id)->where('estado', 'ACTIVO')->count() != 0) {
            $existeimei = true;
        }

        $result = [
            'existeplaca' => $existeplaca,
            'existeimei' => $existeimei
        ];

        return response()->json($result);
    }
    public function gps(Request $request)
    {

        $user = Auth::user();

        if ($user->tipo == 'ADMIN') {
            $resultado = array();
            $dispositivos = DB::select("SELECT t1.* FROM (select d.color,u.id,u.cadena,u.imei,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
            // array_push($var,$dipositivos);
            foreach ($dispositivos as $dispositivo) {
                $ubicaciones = [];
                if ($dispositivo->nombre == "TRACKER 103B") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',2),',',-1) as bateria,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',13),',',-1) as apagado,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',15),',',-1) as prendido from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.bateria!='acc off%' and m.apagado!='0' and m.apagado!=' '"));
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',4),',',-1) as evento from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.evento!='41'"));
                }

                $suma = 0.0;
                for ($i = 0; $i < count($ubicaciones); $i++) {
                    if ($i < count($ubicaciones) - 1) {
                        $response = SphericalUtil::computeDistanceBetween(
                            ['lat' => $ubicaciones[$i]->lat, 'lng' =>  $ubicaciones[$i]->lng], //from array [lat, lng]
                            ['lat' =>  $ubicaciones[$i + 1]->lat, 'lng' =>  $ubicaciones[$i + 1]->lng]
                        );
                        $suma = $suma + $response;
                    }
                }
                array_push($resultado, array(
                    "recorrido" => $suma,
                    "imei" => $dispositivo->imei,
                    "color" => $dispositivo->color,
                    "id" => $dispositivo->id,
                    "cadena" => $dispositivo->cadena,
                    "lat" => $dispositivo->lat,
                    "lng" => $dispositivo->lng,
                    "fecha" => $dispositivo->fecha,
                    "placa" => $dispositivo->placa,
                    "marca" => $dispositivo->marca,
                    "modelo" => $dispositivo->modelo,
                    "nombre" => $dispositivo->nombre
                ));
            }

            return $resultado;
        } else if ($user->tipo == 'CLIENTE') {

            $cliente = DB::table('clientes')->where('user_id', $user->id)->first();
            $dispositivos = DB::select("SELECT t1.* FROM (select d.color,u.id,u.cadena,u.imei,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and c.cliente_id='" . $cliente->id . "') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 and c.cliente_id='" . $cliente->id . "' ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
            $resultado = array();

            // array_push($var,$dipositivos);
            foreach ($dispositivos as $dispositivo) {
                $ubicaciones = [];
                if ($dispositivo->nombre == "TRACKER 103B") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',2),',',-1) as bateria,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',13),',',-1) as apagado,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',15),',',-1) as prendido from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.bateria!='acc off%' and m.apagado!='0' and m.apagado!=' '"));
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',4),',',-1) as evento from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.evento!='41'"));
                }
                $suma = 0.0;
                for ($i = 0; $i < count($ubicaciones); $i++) {
                    if ($i < count($ubicaciones) - 1) {
                        $response = SphericalUtil::computeDistanceBetween(
                            ['lat' => $ubicaciones[$i]->lat, 'lng' =>  $ubicaciones[$i]->lng], //from array [lat, lng]
                            ['lat' =>  $ubicaciones[$i + 1]->lat, 'lng' =>  $ubicaciones[$i + 1]->lng]
                        );
                        $suma = $suma + $response;
                    }
                }
                array_push($resultado, array(
                    "recorrido" => $suma,
                    "imei" => $dispositivo->imei,
                    "color" => $dispositivo->color,
                    "id" => $dispositivo->id,
                    "cadena" => $dispositivo->cadena,
                    "lat" => $dispositivo->lat,
                    "lng" => $dispositivo->lng,
                    "fecha" => $dispositivo->fecha,
                    "placa" => $dispositivo->placa,
                    "marca" => $dispositivo->marca,
                    "modelo" => $dispositivo->modelo,
                    "nombre" => $dispositivo->nombre
                ));
            }

            return $resultado;
        } else if ($user->tipo == 'EMPRESA') {
            $empresa = DB::table('empresas')->where('user_id', $user->id)->first();
            $dispositivos = DB::select("SELECT t1.* FROM (select d.color,u.id,u.cadena,u.imei,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and c.empresa_id='" . $empresa->id . "') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 and c.empresa_id='" . $empresa->id . "' ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
            $resultado = array();

            // array_push($var,$dipositivos);
            foreach ($dispositivos as $dispositivo) {
                $ubicaciones = [];
                if ($dispositivo->nombre == "TRACKER 103B") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',2),',',-1) as bateria,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',13),',',-1) as apagado,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',15),',',-1) as prendido from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.bateria!='acc off%' and m.apagado!='0' and m.apagado!=' '"));
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',4),',',-1) as evento from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.evento!='41'"));
                }
                $suma = 0.0;
                for ($i = 0; $i < count($ubicaciones); $i++) {
                    if ($i < count($ubicaciones) - 1) {
                        $response = SphericalUtil::computeDistanceBetween(
                            ['lat' => $ubicaciones[$i]->lat, 'lng' =>  $ubicaciones[$i]->lng], //from array [lat, lng]
                            ['lat' =>  $ubicaciones[$i + 1]->lat, 'lng' =>  $ubicaciones[$i + 1]->lng]
                        );
                        $suma = $suma + $response;
                    }
                }
                array_push($resultado, array(
                    "recorrido" => $suma,
                    "imei" => $dispositivo->imei,
                    "color" => $dispositivo->color,
                    "id" => $dispositivo->id,
                    "cadena" => $dispositivo->cadena,
                    "lat" => $dispositivo->lat,
                    "lng" => $dispositivo->lng,
                    "fecha" => $dispositivo->fecha,
                    "placa" => $dispositivo->placa,
                    "marca" => $dispositivo->marca,
                    "modelo" => $dispositivo->modelo,
                    "nombre" => $dispositivo->nombre
                ));
            }

            return $resultado;
        }
    }
    public function gpsposicion()
    {
        $data = array();
        $dispositivos = Dispositivo::cursor()->filter(function ($dispositivo) {
            $resultado = false;
            if ($dispositivo->estado == "ACTIVO") {
                $resultado = true;
                $user = Auth::user();
                if ($user->tipo != "ADMIN") {
                    $consulta = DB::table('contrato as c')
                        ->join('detallecontrato as dc', 'c.id', 'dc.contrato_id')->where('dc.dispositivo_id', $dispositivo->id)->where('c.estado', 'ACTIVO');
                    if ($user->tipo == "CLIENTE") {
                        $consulta = $consulta
                            ->join('clientes as cl', 'cl.id', 'c.cliente_id')
                            ->where('cl.user_id', $user->id);
                    } else {
                        $consulta = $consulta
                            ->join('empresas as emp', 'emp.id', 'c.empresa_id')
                            ->where('emp.user_id', $user->id);
                    }
                    if ($consulta->count() == 0) {
                        $resultado = false;
                    }
                }

                return $resultado;
            }
            return $resultado;
        });


        foreach ($dispositivos as $dispositivo) {
            $dispositivo_array = array(
                "imei" => "", "color" => "", "cadena" => "", "lat" => "", "lng" => "", "fecha" => "",
                "placa" => "", "marca" => "", "modelo" => "", "nombre" => "", "estado" => "", "velocidad" => ""
            );
            $dispositivo_array["color"] = $dispositivo->color;
            $dispositivo_array["placa"] = $dispositivo->placa;
            $dispositivo_array["marca"] = $dispositivo->marca;
            $dispositivo_array["modelo"] = $dispositivo->modelo;
            $dispositivo_array["nombre"] = $dispositivo->nombre;
            $dispositivo_array["imei"] = $dispositivo->imei;
            $consulta = DB::table('dispositivo_ubicacion')->where('imei', $dispositivo->imei);
            if ($consulta->count() == 0) {

                $dispositivo_array["estado"] = "sin data";
                array_push($data, $dispositivo_array);
            } else {
                $consulta = $consulta->first();
                $dispositivo_array["cadena"] = $consulta->cadena;
                $dispositivo_array["lat"] = $consulta->lat;
                $dispositivo_array["lng"] = $consulta->lng;
                $dispositivo_array["fecha"] = $consulta->fecha;
                $velocidad_km = "0 kph";
                if ($dispositivo->nombre == "TRACKER303") {
                    $arreglo_cadena = explode(',', $consulta->cadena);
                    if (count($arreglo_cadena) >= 11) {
                        $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                        $velocidad_km = $velocidad_km . " kph";
                    }
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $arreglo_cadena = explode(',', $consulta->cadena);

                    $velocidad_km = floatval($arreglo_cadena[10]) . " kph";
                }
                $dispositivo_array["velocidad"] = $velocidad_km;
                $dispositivo_array["estado"] = "data";
                array_push($data, $dispositivo_array);
            }
        }
        return $data;
    }
    public function prueba()
    {
        $fechainicio = explode(' ', '2021/5/12 0:00')[0];
        $fechafinal = explode(' ', '2021/5/12 23:59:59')[0];
        $fechanow = '2021/6/02';

        $consulta = DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
            ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('m.*', 'd.nombre', 'd.placa')->where([
                ['m.lat', '<>', '0'], ['m.lng', '<>', '0'],
                ['c.empresa_id', '=', '2'], ['c.cliente_id', '=','2']
            ])
            ->whereBetween('m.fecha', ['2021/5/12 0:00', '2021/5/12 23:59:59']);
        if (($fechainicio != $fechanow) && ($fechanow == $fechafinal)) {
            $consulta_dos = $consulta->join('historial as m', 'm.imei', '=', 'd.imei');
            $consulta = DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
                ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('m.*', 'd.nombre', 'd.placa')->where([
                    ['m.lat', '<>', '0'], ['m.lng', '<>', '0'],
                    ['c.empresa_id', '=', '2'], ['c.cliente_id', '=','2']
                ])
                ->whereBetween('m.fecha', ['2021/5/12 0:00', '2021/5/12 23:59:59']);
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->union($consulta_dos)->orderByRaw('d.placa DESC')->get();
        } else if (($fechainicio == $fechafinal) && ($fechanow == $fechainicio)) {
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->orderByDesc('d.placa')->get();
        } else {
            $consulta = $consulta->join('historial as m', 'm.imei', '=', 'd.imei')->orderByDesc('d.placa')->get();
        }
        $dispositivos=DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
        ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('d.nombre', 'd.placa')->orderByDesc('d.placa')->get();
        $dispositivo_agrupar=DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
        ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('d.nombre', 'd.placa')->orderByDesc('d.placa')->first()->placa;
        $data_all=array();
        for ($k=0; $k < count($dispositivos); $k++) {
            array_push($data_all,array("datos"=>[],"nombre"=>$dispositivos[$k]->placa));
        }


        $data = array();
        for ($i = 0; $i < count($consulta); $i++) {
            $velocidad = 0;
            $estado = "Sin movimiento";
            $evento = "-";
            $altitud = 0;
            $cadena = explode(',', $consulta[$i]->cadena);
            $marcador = "";
            if ($i < count($consulta) - 1) {
                $marcador = SphericalUtil::computeDistanceBetween(
                    ['lat' => $consulta[$i]->lat, 'lng' => $consulta[$i]->lng], //from array [lat, lng]
                    ['lat' => $consulta[$i + 1]->lat, 'lng' => $consulta[$i + 1]->lng]
                );
            } else {
                $marcador = "final";
            }
            if ($consulta[$i]->nombre == "MEITRACK") {
                $velocidad = $cadena[10];
                $estado_gps = $cadena[3];
                $altitud = $cadena[13];
                $evento = $cadena[3];
                switch ($estado_gps) {
                    case 2:
                    case 10:
                    case 35:
                        if ($velocidad != "0") {
                            $estado = "movimiento";
                        }
                        break;
                    case 22:
                        $estado = "bateria conectada";
                        break;
                    case 23:
                        $estado = "bateria desconectada";
                        break;
                    case 41:
                        $estado = "Sin movimiento";
                        break;
                    case 42:
                        $estado = "Arranque";
                        break;
                    case 120:
                        $estado = "En movimiento";
                        break;
                    default:
                        $estado = "Sin associar";
                        break;
                }
            } else if ($consulta[$i]->nombre == "TRACKER303") {
                if (count($cadena) >= 11) {
                    $velocidad = floatval($cadena[11]) * 1.85;
                    if ($velocidad != "0") {
                        $estado = "En movimiento";
                    }
                }
            }
            /*$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$consulta[$i]->lat.",".$consulta[$i]->lng."&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI";
            $contexto = stream_context_create($opciones);
            $resultado = file_get_contents($url, false, $contexto);
            $resultado=json_decode($resultado,true);
            array_push($data,array(
                "imei"=>$consulta[$i]->imei,"lat"=>$consulta[$i]->lat,"lng"=>$consulta[$i]->lng,"cadena"=>$consulta[$i]->cadena,
                "velocidad"=>$velocidad." kph","fecha"=>$consulta[$i]->fecha,"direccion"=>$resultado['results'][0]['formatted_address']
            ));*/
            if($consulta[$i]->placa==$dispositivo_agrupar)
            {
                array_push($data, array(
                "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                "velocidad" => $velocidad . " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                "evento" => $evento, "placa" => $consulta[$i]->placa
                  ));
            }
            else
            {
                 $posicion=array_search($dispositivo_agrupar, array_column($data_all, 'nombre'));
                $Clientes[$posicion]['datos']=$data;
                $dispositivo_agrupar=$consulta[$i]->placa;
                $data=array();
                array_push($data, array(
                    "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                    "velocidad" => $velocidad . " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                    "evento" => $evento, "placa" => $consulta[$i]->placa
                      ));
            }

        }
        $posicion=array_search($dispositivo_agrupar, array_column($data_all, 'nombre'));

        $data_all[$posicion]['datos']=$data;
        return response($data_all);
    }
    public function gpsestado(Request $request)
    {
        $user = Auth::user();
        $arreglo = array();

        $dispositivos = dispositivo_user($user);
        foreach ($dispositivos as $dispositivo) {
            $valor = DB::table('estadodispositivo')->where('cadena', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();

            if ($valor != "") {
                $valor = DB::table('estadodispositivo')->where('imei', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();
                if ($valor->estado == "Desconectado") {
                    $arreglo[] = array('imei' => $dispositivo->imei, 'estado' => "Desconectado", 'movimiento' => "Sin Movimiento");
                } else {
                    $arreglo[] = array('imei' => $dispositivo->imei, 'estado' => $valor->estado, 'movimiento' => $valor->movimiento);
                }
            } else {
                $arreglo[] = array('imei' => $dispositivo->imei, 'estado' => "Desconectado", 'movimiento' => "Sin Movimiento");
            }
        }

        return json_encode($arreglo);
    }
    public function verificardispositivo(Request $request)
    {
        $valor = true;
        if (DB::table('ubicacion')->where('imei', $request->imei)->where('lat', '!=', '0')->where('lng', '!=', '0')->count() == 0) {
            $valor = false;
        }
        return json_encode(array("existe" => $valor));
    }
    public function movimiento(Request $request)
    {
        $user = Auth::user();
        $activos = dispositivo_activos($user);
        $inactivos = dispositivo_inactivos($user);
        $resultado = array();
        $resultado = array("activos" => $activos, "inactivos" => $inactivos);
        return $resultado;
    }
    public function ruta(Request $request)
    {
        $data = array();
        $fila = DB::table('ubicacion_recorrido as ur')->join('dispositivo as d','d.imei','=','ur.imei')
                            ->select('ur.*','d.nombre','d.placa')
                            ->where('ur.imei', $request->imei)->orderBy('ur.fecha', 'asc')->get();
        for ($i = 0; $i < count($fila); $i++) {
            
            $arreglo_cadena = explode(',', $fila[$i]->cadena);
            $velocidad_km="0 kph";
            $altitud="0 Metros";
            $odometro="0 Km";
            $nivelCombustible="0%";
            $volumenCombustible="0.0 gal";
            $horaDelMotor="0.0";
            $intensidadSenal="0.0";
            $estado="Sin Movimiento";

            if ($fila[$i]->nombre == "TRACKER303") {


                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $vkm=$velocidad_km;
                    $estado=($velocidad_km<=0)?$estado:"En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km). " kph";

            } else if ($fila[$i]->nombre == "MEITRACK") {

                $velocidad_km = floatval($arreglo_cadena[10]);
                $vkm=$velocidad_km;
                $estado=($velocidad_km<=0)?$estado:"En Movimiento";
                $altitud = $arreglo_cadena[13];
                $velocidad_km = sprintf("%.2f", $velocidad_km). " kph";
            }
            
            if($vkm>2)
            {
                array_push($data, array("placa"=>$fila[$i]->placa,
                "imei" => $fila[$i]->imei,
                "estado"=>$estado,
                "lat" => $fila[$i]->lat,
                "intensidadSenal"=>$intensidadSenal,
                "lng" => $fila[$i]->lng,
                "fecha" => $fila[$i]->fecha,
                "altitud" => $altitud,
                "velocidad"=>$velocidad_km,
                "nivelCombustible" =>$nivelCombustible,
                "volumenCombustible" =>$volumenCombustible,
                "horaDelMotor" =>$horaDelMotor,
                "direccion"=>$fila[$i]->direccion,
                "odometro"=>$odometro));
            }
            
        }
        return $data;
    }
}
